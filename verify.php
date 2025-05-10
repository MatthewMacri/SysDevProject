<?php
require 'vendor/autoload.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$data = json_decode(file_get_contents("php://input"), true);
$token = $data['token'] ?? '';

if (empty($token)) {
    http_response_code(400);
    echo json_encode(["error" => "Token not provided"]);
    exit;
}

if (!isset($_SESSION['role']) || !isset($_SESSION['id'])) {
    http_response_code(403);
    echo json_encode(["error" => "Not authenticated"]);
    exit;
}

$table = $_SESSION['role'] === 'admin' ? 'admin' : 'user';
$idField = $table === 'admin' ? 'admin_id' : 'user_id';
$id = $_SESSION['id'];

$db = new PDO("sqlite:database/Datab.db");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $db->prepare("SELECT twofa_secret FROM $table WHERE $idField = ?");
$stmt->execute([$id]);
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
    echo json_encode(["success" => true, "role" => $table]);
} else {
    http_response_code(401);
    echo json_encode(["error" => "Invalid 2FA code"]);
}
