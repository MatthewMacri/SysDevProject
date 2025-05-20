<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
ob_start();

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';
require_once dirname(__DIR__, 2) . '/bootstrap/app.php';
require_once dirname(__DIR__, 2) . '/app/Http/Controllers/core/DatabaseController.php';
require_once app_path('Models/users/User.php');

use App\Models\users\User;
use App\Http\Controllers\core\DatabaseController;

session_start();

if (!isset($_SESSION['admin_id'])) {
  echo json_encode(['success' => false, 'message' => 'Not authorized.']);
  exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$username = $data['username'] ?? '';
$newPassword = $data['newPassword'] ?? '';
$adminPassword = $data['adminPassword'] ?? '';

if (!$username || !$newPassword || !$adminPassword) {
  echo json_encode(['success' => false, 'message' => 'Missing data.']);
  exit;
}

try {
  $database = DatabaseController::getInstance();
  $db = $database->getConnection();
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Fetch admin password
  $stmt = $db->prepare("SELECT password FROM Admins WHERE admin_id = ?");
  $stmt->execute([$_SESSION['admin_id']]);
  $admin = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$admin) {
    echo json_encode(['success' => false, 'message' => 'Admin not found.']);
    exit;
  }

  $key = hex2bin('796a3a9391c45035412c62f92e889080');

  $encryptionKey = '796a3a9391c45035412c62f92e889080';
  $decryptedPassword = openssl_decrypt($admin['password'], 'AES-128-ECB', $encryptionKey);

  if ($decryptedPassword === false) {
      echo json_encode(['success' => false, 'message' => 'Failed to decrypt stored admin password.']);
      exit;
  }

  if ($adminPassword !== $decryptedPassword) {
      echo json_encode(['success' => false, 'message' => 'Admin password is incorrect.']);
      exit;
  }
  
  // Update target user's password
  $encoded = base64_encode($newPassword);
  $stmt = $db->prepare("UPDATE Users SET password = ? WHERE user_name = ?");
  $stmt->execute([$encoded, $username]);

  if ($stmt->rowCount() === 0) {
    echo json_encode(['success' => false, 'message' => 'User not found or password not updated.']);
  } else {
    echo json_encode(['success' => true, 'message' => 'Password updated successfully.']);
  }
} catch (PDOException $e) {
  echo json_encode(['success' => false, 'message' => 'DB error: ' . $e->getMessage()]);
}
