<?php


require_once dirname(__DIR__, 3) . '/vendor/autoload.php';
$app = require_once dirname(__DIR__, 3) . '/bootstrap/app.php';

require_once app_path('Http/Controllers/core/databaseController.php');

use App\Http\Controllers\core\DatabaseController;
use App\Http\Controllers\entitiesControllers\Usercontroller;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['adminPassword'])) {
  require_once $_SERVER['DOCUMENT_ROOT'] . '/SysDevProject/app/Http/Controllers/core/databasecontroller.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/SysDevProject/app/Models/users/ApplicationUser.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/SysDevProject/app/Http/Controllers/entitiesControllers/Usercontroller.php';

  session_start();
  $db = DatabaseController::getInstance();
  $userController = new Usercontroller($db);

  if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
  }

  $username = $_POST['username'];
  $adminPassword = $_POST['adminPassword'];

  $pdo = $db->getConnection();
  $stmt = $pdo->prepare("SELECT * FROM Admins WHERE admin_name = ?");
  $stmt->execute([$_SESSION['username']]);
  $admin = $stmt->fetch(PDO::FETCH_ASSOC);

  $encryptionKey = '796a3a9391c45035412c62f92e889080';
  $decryptedPassword = openssl_decrypt($admin['password'], 'AES-128-ECB', $encryptionKey);

  if ($decryptedPassword === false || $adminPassword !== $decryptedPassword) {
      echo json_encode(['success' => false, 'message' => 'Admin password incorrect']);
      exit;
  }

  $result = $userController->deleteUserByUsername($username);
  header('Content-Type: application/json');
  echo json_encode($result);
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Delete User</title>
  <link rel="icon" type="image/png" href="/SysDevProject/public/images/logo/favicon-gear.png" />
  <link rel="stylesheet" href="../../css/deleteUser.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>

<body>

  <?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/SysDevProject/config/config.php';
    require BASE_PATH . '/resources/components/navbar.php';
  ?>

  <div class="form-container">
    <div class="form-box">
      <label for="username">Username</label>
      <input type="text" id="username" placeholder="TGUser" />
      <label for="admin-password">Admin Password</label>
      <input type="password" id="admin-password" placeholder="Value" />
      <div class="buttons">
        <button class="deleteButton">Delete User</button>
      </div>
    </div>
  </div>

<div id="deleteConfirmBox" class="popup-overlay hidden-overlay">
  <div class="popup-box">
    <p>You are deleting user <span id="deleteUserID"></span>.<br>Confirm to proceed.</p>
    <div class="popup-buttons">
      <button class="orange-btn" onclick="hideDeleteConfirmBox()">Cancel</button>
      <button class="orange-btn" id="confirmDeleteBtn">Confirm</button>
    </div>
  </div>
</div>

  <script>
    function hideDeleteConfirmBox() {
      document.getElementById("deleteConfirmBox").style.display = "none";
    }

    function showDeleteConfirmBox(username) {
      document.getElementById("deleteUserID").textContent = username;
      document.getElementById("deleteConfirmBox").style.display = "flex";
    }

    document.addEventListener("DOMContentLoaded", () => {
      document.getElementById("deleteConfirmBox").style.display = "none"; // Ensure hidden on load

      const deleteBtn = document.querySelector(".deleteButton");
      const confirmBtn = document.getElementById("confirmDeleteBtn");

      deleteBtn.addEventListener("click", () => {
        const username = document.getElementById("username").value.trim();
        if (!username) return alert("Enter a username");
        showDeleteConfirmBox(username);
      });

      confirmBtn.addEventListener("click", () => {
        const username = document.getElementById("username").value.trim();
        const adminPassword = document.getElementById("admin-password").value.trim();

        if (!username || !adminPassword) {
          alert("Please enter both username and admin password.");
          return;
        }

        fetch("", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: new URLSearchParams({ username, adminPassword }),
        })
        .then(res => res.json())
        .then(data => {
          alert(data.message);
          if (data.success) {
            hideDeleteConfirmBox();
            location.reload();
          }
        })
        .catch(err => {
          console.error("Delete failed:", err);
          alert("An error occurred while deleting.");
        });
      });
    });
  </script>

</body>
</html>