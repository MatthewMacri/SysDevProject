<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Controllers\DatabaseController;

class AuthController {

    public function sendResetLink() {
        $email = $_POST['email'] ?? '';
        if (!$email) return;

        $db = DatabaseController::getInstance();
        $pdo = $db->getConnection();

        // Verify that the email exists in either Users or Admins
        $stmt = $pdo->prepare("SELECT email FROM Users WHERE email = ? UNION SELECT email FROM Admins WHERE email = ?");
        $stmt->execute([$email, $email]);
        if (!$stmt->fetch()) {
            die("Email not found.");
        }

        $token = bin2hex(random_bytes(32));
        $expires = time() + 1800;

        // Save token in DB using a helper (or raw query)
        $db->saveResetToken($email, $token, $expires);

        // Send email using PHPMailer
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.example.com';         // ⚠️ Change this
        $mail->SMTPAuth = true;
        $mail->Username = 'you@example.com';      // ⚠️ Change this
        $mail->Password = 'yourpassword';         // ⚠️ Change this
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

        $db = DatabaseController::getInstance();
        $pdo = $db->getConnection();

        $stmt = $pdo->prepare("SELECT email FROM password_resets WHERE token = ? AND expires_at >= ?");
        $stmt->execute([$token, time()]);
        $row = $stmt->fetch();

        if (!$row) {
            die("Invalid or expired token.");
        }

        $hashed = password_hash($password, PASSWORD_DEFAULT);

        // Try updating in Admins
        $admin = $pdo->prepare("UPDATE Admins SET password = ? WHERE email = ?");
        $admin->execute([$hashed, $row['email']]);

        if ($admin->rowCount() === 0) {
            // Fallback to Users
            $user = $pdo->prepare("UPDATE Users SET password = ? WHERE email = ?");
            $user->execute([$hashed, $row['email']]);
        }

        // Delete token after use
        $db->deleteResetToken($token);

        echo "Password updated successfully.";
    }
}
