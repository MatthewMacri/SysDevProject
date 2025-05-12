<?php
// Enable all error reporting (useful during development)
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Debug line to confirm this script is hit
file_put_contents("debug.txt", "LOGIN HIT\n", FILE_APPEND);

// Allow CORS for local testing (you can tighten this in production)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

// If the request is an OPTIONS preflight, stop here
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Load external libraries (like PHPGangsta)
require 'vendor/autoload.php';

// Read incoming JSON data from the frontend
$data = json_decode(file_get_contents("php://input"), true);
$username = $data['username'];
$password = $data['password'];

// Connect to the SQLite database
$db = new PDO("sqlite:database/database.sqlite");$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$role = null;  // Will hold either 'admin' or 'user'

// First check if the user is an admin
$stmt = $db->prepare("SELECT * FROM Admins WHERE admin_name = ?");
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    $role = 'admin';
} else {
    // If not found in admin table, check user table
    $role = 'user';
    $stmt = $db->prepare("SELECT * FROM Users WHERE user_name = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Log info for debugging
file_put_contents("debug.txt", "User result: " . json_encode($user) . "\n", FILE_APPEND);
file_put_contents("debug.txt", "Input password: $password\n", FILE_APPEND);
file_put_contents("debug.txt", "Stored hash: " . ($user['password'] ?? 'null') . "\n", FILE_APPEND);

// Check if the entered password matches the stored hashed password
$isValid = password_verify($password, $user['password']);
file_put_contents("debug.txt", "password_verify result: " . ($isValid ? "true" : "false") . "\n", FILE_APPEND);

// If user not found or password incorrect, stop here
if (!$user || !$isValid) {
    http_response_code(401);  // Unauthorized
    echo json_encode(["error" => "Invalid username or password"]);
    exit;
}

// Save session variables depending on user role
if ($role == 'admin') {
    $_SESSION['role'] = 'admin';
    $_SESSION['admin_id'] = $user['admin_id'];
    $_SESSION['id'] = $user['admin_id'];
    $idField = 'admin_id';
    $table = 'admin';
} else {
    $_SESSION['role'] = 'user';
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['id'] = $user['user_id']; 
    $idField = 'user_id';
    $table = 'user';
}

// Lock the session data
session_write_close();

// Setup 2FA (Google Authenticator)
$g = new PHPGangsta_GoogleAuthenticator();
$secret = $user['twofa_secret'] ?: $g->createSecret();

// Save the secret to DB if it didn't exist
if (!$user['twofa_secret']) {
    $update = $db->prepare("UPDATE $table SET twofa_secret = ? WHERE $idField = ?");
    $update->execute([$secret, $user[$idField]]);
}

// Generate the QR code URL to show in frontend for scanning
$qr = $g->getQRCodeGoogleUrl($username, $secret, 'TexasGearsApp');

// Return 2FA setup info to frontend
echo json_encode([
    "success" => true,
    "qr" => $qr,
    "secret" => $secret
]);