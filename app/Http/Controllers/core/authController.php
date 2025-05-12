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
            die("No email provided.");
        }

        // Generate secure token
        $token = bin2hex(random_bytes(32));
        $expires = time() + 1800; // valid for 30 minutes

        // Get DB connection
        $db = DatabaseController::getInstance();
        $pdo = $db->getConnection();

        // Delete previous tokens for this email
        $pdo->prepare("DELETE FROM password_resets WHERE email = ?")->execute([$email]);

        // Insert new token
        $pdo->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)")
            ->execute([$email, $token, $expires]);

        // Build reset link
        $resetLink = "http://localhost/SysDevProject/resources/views/resetPassword.php?token=$token";

        // Send email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';              // Use your actual SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'tgearspassreset@gmail.com';     // Use your Gmail
        $mail->Password = 'ugog hhvj lmcw xqcb';       // Use your Gmail app password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('youremail@gmail.com', 'Texas Gears');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Reset Your Password';
        $mail->Body = "Hi,<br><br>We received a password reset request for your account.<br>
            Click the link below to set a new password:<br><br>
            <a href='$resetLink'>$resetLink</a><br><br>
            If you didn’t request this, ignore this email.<br><br>Thanks!";

        if ($mail->send()) {
            echo "✅ Email sent successfully to $email";
        } else {
            echo "❌ Failed: " . $mail->ErrorInfo;
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
