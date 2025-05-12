<?php

namespace Controllers;

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Controllers\DatabaseController;

class AuthController {

    /**
     * Sends a password reset link to the provided email.
     */
    public function sendResetLink() {
        // Step 1: Get the email from POST request
        $email = $_POST['email'] ?? '';
        if (!$email) return; // Exit if no email is provided

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
        $pdo = new \PDO('sqlite:database/Datab.db');
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
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('you@example.com', 'Texas Gears');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Reset Your Password';
        $mail->Body = "Click this link to reset your password: 
            <a href='http://localhost/SysDevProject/resources/views/password/resetPassword.php?token=$token'>Reset Password</a>";

        // Step 7: Send the email and handle success/failure
        if ($mail->send()) {
            header("Location: ../../resources/views/login/login.html?reset=sent");  // Redirect after successful email
            exit;
        } else {
            echo "Failed to send email: " . $mail->ErrorInfo;  // Error handling if email fails to send
        }
    }

    /**
     * Resets the user's password using the provided token and new password.
     */
    public function resetPassword() {
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

        // Step 7: Return success message
        echo "Password updated successfully.";
    }
}