<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

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

$role = null;

$stmt = $db->prepare("SELECT * FROM admin WHERE admin_name = ?");
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    $role = 'admin';
} else {
    $role = 'user';
    $stmt = $db->prepare("SELECT * FROM user WHERE user_name = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}

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

session_write_close();

$g = new PHPGangsta_GoogleAuthenticator();
$secret = $user['twofa_secret'] ?: $g->createSecret();

if (!$user['twofa_secret']) {
    $update = $db->prepare("UPDATE $table SET twofa_secret = ? WHERE $idField = ?");
    $update->execute([$secret, $user[$idField]]);
}

$qr = $g->getQRCodeGoogleUrl($username, $secret, 'TexasGearsApp');
echo json_encode([
    "success" => true,
    "qr" => $qr,
    "secret" => $secret
]);

