<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/SysDevProject/app/Http/Controllers/core/DatabaseController.php';


use App\Http\Controllers\core\DatabaseController;

if(session_status()==PHP_SESSION_NONE)session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['admin_id'])) {
  echo json_encode(['success' => false, 'message' => 'Not authorized.']);
  exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$username = $data['username'] ?? '';
$adminPassword = $data['adminPassword'] ?? '';
$deactivated = $data['deactivated'] ?? '';

if (!$username || !isset($deactivated) || !$adminPassword) {
  echo json_encode(['success' => false, 'message' => 'Missing data.']);
  exit;
}

try {
  $database = DatabaseController::getInstance();
  $db = $database->getConnection();
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Get admin's actual password
  $stmt = $db->prepare("SELECT password FROM Admins WHERE admin_id = ?");
  $stmt->execute([$_SESSION['admin_id']]);
  $admin = $stmt->fetch(PDO::FETCH_ASSOC);

  $encryptionKey = '796a3a9391c45035412c62f92e889080'; // Same key as in login
  $decryptedAdminPassword = openssl_decrypt($admin['password'], 'AES-128-ECB', $encryptionKey);

  if (!$admin || $decryptedAdminPassword !== $adminPassword) {
      echo json_encode(['success' => false, 'message' => 'Admin password is incorrect.']);
      exit;
  }

  // Encode and update new password
  $is_deactivated = $deactivated;
  $stmt = $db->prepare("UPDATE Users SET is_deactivated = ? WHERE user_name = ?");
  $stmt->execute([$is_deactivated, $username]);

  echo json_encode(['success' => true, 'message' => 'account deactivation status changed successfully.']);
} catch (PDOException $e) {
  echo json_encode(['success' => false, 'message' => 'DB error: ' . $e->getMessage()]);
}