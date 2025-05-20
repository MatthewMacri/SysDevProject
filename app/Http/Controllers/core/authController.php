<?php

namespace App\Http\Controllers\core;

require_once dirname(__DIR__, 4) . '/vendor/autoload.php';
require_once __DIR__ . '/databaseController.php';
$app = require_once dirname(__DIR__, 4) . 'bootstrap/app/php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Http\Controllers\core\DatabaseController;

class AuthController
{

    /**
     * Sends a password reset link to the provided email.
     */
    public function sendResetLink()
    {
        // Step 1: Get the email from POST request
        $email = $_POST['email'] ?? '';
        if (!$email)
            return; // Exit if no email is provided

        // Step 2: Check if the email exists in either Users or Admins
        $db = DatabaseController::getInstance();
        $pdo = $db->getConnection();

        // Query to check if email exists in Users or Admins
        $stmt = $pdo->prepare("SELECT email FROM Users WHERE email = ? UNION SELECT email FROM Admins WHERE email = ?");
        $stmt->execute([$email, $email]);
        if (!$stmt->fetch()) {
            die("Email not found."); // Exit if email doesn't exist
        }

        // Step 3: Generate a reset token and expiration time (30 minutes)
        $token = bin2hex(random_bytes(32));  // Generate a secure random token
        $expires = time() + 1800;  // Token expires in 30 minutes

        // Step 4: Save the token to the database (helper or raw query)
        $db->saveResetToken($email, $token, $expires);

        // Step 5: Insert token into the password_resets table in the database
        $databasePath = database_path('texasgears.db');
        if (!file_exists($databasePath)) {
            die("SQLite file not found at: " . $databasePath);
        }
        $pdo = new \PDO('sqlite:' . $databasePath);
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)");
        $stmt->execute([$email, $token, $expires]);

        // Step 6: Set up and send the email using PHPMailer
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.example.com';         // Change to actual SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'you@example.com';      // Change to actual email
        $mail->Password = 'yourpassword';         // Change to actual password
        if (!$email) {
            echo "❌ No email provided.";
            return;
        }

        // Generate token
        $token = bin2hex(random_bytes(32));
        $expires = time() + 1800;

        // Get DB instance
        require_once __DIR__ . '/databaseController.php'; // if needed
        $db = DatabaseController::getInstance();
        $pdo = $db->getConnection();

        // Save token
        $pdo->prepare("DELETE FROM password_resets WHERE email = ?")->execute([$email]);
        $pdo->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)")
            ->execute([$email, $token, $expires]);

        // Send email
        $resetLink = "http://localhost:8000/resources/views/resetPassword.php?token=$token";

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'youremail@gmail.com';
        $mail->Password = 'your_app_password';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('youremail@gmail.com', 'Texas Gears');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Reset Your Password';
        $mail->Body = "Click here to reset your password: <a href='$resetLink'>$resetLink</a>";

        // Step 7: Send the email and handle success/failure
        if ($mail->send()) {
            header("Location: ../../resources/views/login/login.html?reset=sent");  // Redirect after successful email
            exit;
        } else {
            echo "Failed to send email: " . $mail->ErrorInfo;  // Error handling if email fails to send
            echo "✅ Reset link sent to $email";
        }
    }

    /**
     * Resets the user's password using the provided token and new password.
     */
    public function resetPassword()
    {
        // Step 1: Get token and new password from POST data
        $token = $_POST['token'] ?? '';
        $password = $_POST['password'] ?? '';

        // Step 2: Check if the token is valid and not expired
        $db = DatabaseController::getInstance();
        $pdo = $db->getConnection();

        // Query to check if token is valid and has not expired
        $stmt = $pdo->prepare("SELECT email FROM password_resets WHERE token = ? AND expires_at >= ?");
        $stmt->execute([$token, time()]);
        $row = $stmt->fetch();

        if (!$row) {
            die("Invalid or expired token.");  // Exit if token is invalid or expired
        }

        // Step 3: Hash the new password
        $hashed = password_hash($password, PASSWORD_DEFAULT);  // Hash the new password using bcrypt

        // Step 4: Attempt to update the password in the Admin table
        $admin = $pdo->prepare("UPDATE Admins SET password = ? WHERE email = ?");
        $admin->execute([$hashed, $row['email']]);

        // Step 5: If the password is not updated in Admins, try updating in Users
        if ($admin->rowCount() === 0) {
            $user = $pdo->prepare("UPDATE Users SET password = ? WHERE email = ?");
            $user->execute([$hashed, $row['email']]);
        }

        // Step 6: Delete the reset token after use
        $db->deleteResetToken($token);
        // Remove used token
        $pdo->prepare("DELETE FROM password_resets WHERE token = ?")->execute([$token]);

        // Step 7: Return success message
        echo "Password updated successfully.";
    }
}

//ROUTER: handles requests from forms like forgotPassword.php
$auth = new AuthController();
$action = $_GET['action'] ?? '';

if ($action === 'sendResetLink') {
    $auth->sendResetLink();
} elseif ($action === 'resetPassword') {
    $auth->resetPassword();
}
