<?php
session_start();
$db = new PDO("sqlite:../../database/Datab.db");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$email = $_POST['email'] ?? '';
if (!$email) {
    die("Email is required.");
}

// Check in admin and user tables
$adminStmt = $db->prepare("SELECT * FROM admin WHERE email = ?");
$adminStmt->execute([$email]);
$admin = $adminStmt->fetch(PDO::FETCH_ASSOC);

$userStmt = $db->prepare("SELECT * FROM user WHERE email = ?");
$userStmt->execute([$email]);
$user = $userStmt->fetch(PDO::FETCH_ASSOC);

if (!$admin && !$user) {
    die("No account found with that email.");
}

$token = bin2hex(random_bytes(16));
$expires = time() + 3600; // 1 hour

$db->exec("CREATE TABLE IF NOT EXISTS reset_tokens (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    email TEXT,
    token TEXT,
    expires INTEGER
)");

$stmt = $db->prepare("INSERT INTO reset_tokens (email, token, expires) VALUES (?, ?, ?)");
$stmt->execute([$email, $token, $expires]);

$resetLink = "http://localhost/SysDevProject/resources/views/resetPassword.php?token=$token";

$to = $email;
$subject = "Password Reset Request";
$message = "Click the following link to reset your password: $resetLink";
$headers = "From: no-reply@texasgears.com";

mail($to, $subject, $message, $headers);

echo "A password reset link has been sent to your email address.";
?>