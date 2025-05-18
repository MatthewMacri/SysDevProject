<?php
session_start();

require_once dirname(__DIR__, 3) . '/vendor/autoload.php';
$app = require_once dirname(__DIR__, 3) . '/bootstrap/app.php';

require_once app_path('Http/Controllers/core/databaseController.php');

use App\Http\Controllers\core\DatabaseController;
// Connect to SQLite database
$database = DatabaseController::getInstance();
$db = $database->getConnection();
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Get the submitted email from the form
$email = $_POST['email'] ?? '';

// Validate presence of email
if (!$email) {
    die("Email is required.");
}

// Check if the email exists in the admin table
$adminStmt = $db->prepare("SELECT * FROM admin WHERE email = ?");
$adminStmt->execute([$email]);
$admin = $adminStmt->fetch(PDO::FETCH_ASSOC);

// Check if the email exists in the user table
$userStmt = $db->prepare("SELECT * FROM user WHERE email = ?");
$userStmt->execute([$email]);
$user = $userStmt->fetch(PDO::FETCH_ASSOC);

// If no matching email is found in either table, show error
if (!$admin && !$user) {
    die("No account found with that email.");
}

// Generate a secure random token and expiration time (1 hour)
$token = bin2hex(random_bytes(16));
$expires = time() + 3600;

// Create the reset_tokens table if it doesn't already exist
$db->exec("CREATE TABLE IF NOT EXISTS reset_tokens (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    email TEXT,
    token TEXT,
    expires INTEGER
)");

// Store the token, associated email, and expiration time
$stmt = $db->prepare("INSERT INTO reset_tokens (email, token, expires) VALUES (?, ?, ?)");
$stmt->execute([$email, $token, $expires]);

// Generate the reset password link using the token
$resetLink = "http://localhost/SysDevProject/resources/views/resetPassword.php?token=$token";

// Email details
$to = $email;
$subject = "Password Reset Request";
$message = "Click the following link to reset your password:\n\n$resetLink\n\nThis link will expire in 1 hour.";
$headers = "From: no-reply@texasgears.com";

// Send the email
mail($to, $subject, $message, $headers);

// Show confirmation message to the user
echo "A password reset link has been sent to your email address.";
?>