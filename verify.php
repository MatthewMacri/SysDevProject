<?php 

require 'vendor/autoload.php';
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}


$data = json_decode(file_get_contents("php://input"), true);
$token = $data['token'];


// ✅ Use the session to identify the logged-in admin
if (!isset($_SESSION['admin_id'])) {
    http_response_code(403);
    echo json_encode(["error" => "Not authenticated"]);
    exit;
}

// Fetch the admin's stored 2FA secret
$db = new PDO("sqlite:database/Datab.db");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $db->prepare("SELECT twofa_secret FROM admin WHERE admin_id = ?");
$stmt->execute([$_SESSION['admin_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || empty($user['twofa_secret'])) {
    http_response_code(401);
    echo json_encode(["error" => "2FA not configured"]);
    exit;
}

$secret = $user['twofa_secret'];
$g = new PHPGangsta_GoogleAuthenticator();
$isValid = $g->verifyCode($secret, $token, 2); // 2 = time window tolerance



if ($isValid) {
    echo json_encode(["success" => true]);
} else {
    http_response_code(401);
    echo json_encode(["error" => "Invalid 2FA code"]);
}