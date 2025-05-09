<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class AuthController {

    public function sendResetLink() {
        $email = $_POST['email'] ?? '';
        if (!$email) return;

        $token = bin2hex(random_bytes(32));
        $expires = time() + 1800;

        $pdo = new PDO('sqlite:database/Datab.db');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)");
        $stmt->execute([$email, $token, $expires]);

        // Send email using PHPMailer
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.example.com';         // ⚠️ Replace with real SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'you@example.com';      // ⚠️ Replace with real email
        $mail->Password = 'yourpassword';         // ⚠️ Replace with real password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('you@example.com', 'Texas Gears');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Reset Your Password';
        $mail->Body = "Click this link to reset your password: 
            <a href='http://localhost/SysDevProject/resources/views/resetPassword.php?token=$token'>Reset Password</a>";

        if ($mail->send()) {
            header("Location: ../../resources/views/login.html?reset=sent");
            exit;
        } else {
            echo "Failed to send email: " . $mail->ErrorInfo;
        }
    }

    public function resetPassword() {
        $token = $_POST['token'] ?? '';
        $password = $_POST['password'] ?? '';

        $pdo = new PDO('sqlite:database/Datab.db');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT email FROM password_resets WHERE token = ? AND expires_at >= ?");
        $stmt->execute([$token, time()]);
        $row = $stmt->fetch();

        if (!$row) {
            die("Invalid or expired token.");
        }

        $hashed = password_hash($password, PASSWORD_DEFAULT);

        // Try admin table first
        $admin = $pdo->prepare("UPDATE admin SET password = ? WHERE email = ?");
        $admin->execute([$hashed, $row['email']]);

        if ($admin->rowCount() === 0) {
            // Try user table
            $user = $pdo->prepare("UPDATE user SET password = ? WHERE email = ?");
            $user->execute([$hashed, $row['email']]);
        }

        $pdo->prepare("DELETE FROM password_resets WHERE token = ?")->execute([$token]);

        echo "Password updated successfully.";
    }
}