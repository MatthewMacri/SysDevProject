<?php

use App\Http\Controllers\core\DatabaseController;
// Load dependencies (like PHPGangsta GoogleAuthenticator)
require 'vendor/autoload.php';

// Start session if it hasn't already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Read JSON input from frontend
$data = json_decode(file_get_contents("php://input"), true);
$token = $data['token'] ?? ''; // The 2FA code entered by the user

// If token is missing, return error
if (empty($token)) {
    http_response_code(400); // Bad request
    echo json_encode(["error" => "Token not provided"]);
    exit;
}

// Make sure the user is logged in and role is set
if (!isset($_SESSION['role']) || !isset($_SESSION['id'])) {
    http_response_code(403); // Forbidden
    echo json_encode(["error" => "Not authenticated"]);
    exit;
}

// Determine which table to query based on the role
$table = $_SESSION['role'] === 'admin' ? 'Admins' : 'Users';
$idField = $table === 'Admins' ? 'admin_id' : 'user_id';
$id = $_SESSION['id'];

// Connect to SQLite database
$databaseInstance = DatabaseController::getInstance();
$db = $databaseInstance->getConnection();
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Get the user's 2FA secret key
$stmt = $db->prepare("SELECT twofa_secret FROM $table WHERE $idField = ?");
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// If no secret found, reject the request
if (!$user || empty($user['twofa_secret'])) {
    http_response_code(401); // Unauthorized
    echo json_encode(["error" => "2FA not configured"]);
    exit;
}

// Verify the token using the stored secret
$secret = $user['twofa_secret'];
$g = new PHPGangsta_GoogleAuthenticator();
$isValid = $g->verifyCode($secret, $token, 2); // "2" allows ±30 seconds

// If valid, allow login
if ($isValid) {
    echo json_encode(["success" => true, "role" => $table]);
} else {
    // If invalid, return error
    http_response_code(401); // Unauthorized
    echo json_encode(["error" => "Invalid 2FA code"]);
}