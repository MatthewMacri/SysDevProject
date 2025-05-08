<?php

file_put_contents("debug.txt", "LOGIN HIT\n", FILE_APPEND);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require 'vendor/autoload.php';

$data = json_decode(file_get_contents("php://input"), true);
$username = $data['username'];
$password = $data['password'];

$db = new PDO("sqlite:database/Datab.db");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $db->prepare("SELECT * FROM admin WHERE admin_name = ?");
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

file_put_contents("debug.txt", "User result: " . json_encode($user) . "\n", FILE_APPEND);
file_put_contents("debug.txt", "Input password: $password\n", FILE_APPEND);
file_put_contents("debug.txt", "Stored hash: " . ($user['password'] ?? 'null') . "\n", FILE_APPEND);

$isValid = password_verify($password, $user['password']);
file_put_contents("debug.txt", "password_verify result: " . ($isValid ? "true" : "false") . "\n", FILE_APPEND);

if (!$user || !$isValid) {
    http_response_code(401);
    echo json_encode(["error" => "Invalid username or password"]);
    exit;
}

$g = new PHPGangsta_GoogleAuthenticator();
$secret = $user['twofa_secret'] ?: $g->createSecret();

if (!$user['twofa_secret']) {
    $update = $db->prepare("UPDATE admin SET twofa_secret = ? WHERE admin_id = ?");
    $update->execute([$secret, $user['admin_id']]);
}

$qr = $g->getQRCodeGoogleUrl($username, $secret, 'TexasGearsApp');
echo json_encode([
    "success" => true,
    "qr" => $qr,
    "secret" => $secret
  ]);
  

