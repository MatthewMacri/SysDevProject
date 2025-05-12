<?php

namespace Controllers;

require __DIR__ . '/../../../../vendor/autoload.php';
require_once __DIR__ . '/DatabaseController.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class AuthController {

    public function sendResetLink() {
        $email = $_POST['email'] ?? '';
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

        if ($mail->send()) {
            echo "✅ Reset link sent to $email";
        } else {
            echo "❌ Failed to send: " . $mail->ErrorInfo;
        }
    }

    public function resetPassword() {
        $token = $_POST['token'] ?? '';
        $password = $_POST['password'] ?? '';

        $db = DatabaseController::getInstance();
        $pdo = $db->getConnection();

        // Check if token is valid
        $stmt = $pdo->prepare("SELECT email FROM password_resets WHERE token = ? AND expires_at >= ?");
        $stmt->execute([$token, time()]);
        $row = $stmt->fetch();

        if (!$row) {
            die("Invalid or expired token.");
        }

        // Hash and update password
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $admin = $pdo->prepare("UPDATE Admins SET password = ? WHERE email = ?");
        $admin->execute([$hashed, $row['email']]);

        if ($admin->rowCount() === 0) {
            $user = $pdo->prepare("UPDATE Users SET password = ? WHERE email = ?");
            $user->execute([$hashed, $row['email']]);
        }

        // Remove used token
        $pdo->prepare("DELETE FROM password_resets WHERE token = ?")->execute([$token]);

        echo "Password updated successfully.";
    }
}

// ✅ ROUTER: handles requests from forms like forgotPassword.php
$auth = new AuthController();
$action = $_GET['action'] ?? '';

if ($action === 'sendResetLink') {
    $auth->sendResetLink();
} elseif ($action === 'resetPassword') {
    $auth->resetPassword();
}
