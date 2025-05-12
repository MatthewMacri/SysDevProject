<?php
use App\Http\Controllers\core\DatabaseController;
use Controllers\Usercontroller;

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

  if (!$admin || !password_verify($adminPassword, $admin['password'])) {
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

  <div id="deleteConfirmBox" class="hidden-overlay">
    <div class="confirm-content">
      <p>You are deleting user <span id="deleteUserID"></span><br>Confirm to Proceed</p>
      <div class="confirm-buttons">
        <button class="btn" onclick="hideDeleteConfirmBox()">Cancel</button>
        <button class="btn" id="confirmDeleteBtn">Confirm</button>
      </div>
    </div>
  </div>

  <script>
    function hideDeleteConfirmBox() {
      document.getElementById("deleteConfirmBox").style.display = "none";
    }

    document.querySelector(".deleteButton").addEventListener("click", () => {
      const username = document.getElementById("username").value;
      if (username.trim() === "") return alert("Enter a username");

      document.getElementById("deleteUserID").textContent = username;
      document.getElementById("deleteConfirmBox").style.display = "block";
    });

    document.getElementById("confirmDeleteBtn").addEventListener("click", () => {
      const username = document.getElementById("username").value;
      const adminPassword = document.getElementById("admin-password").value;

      fetch("", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: new URLSearchParams({
          username,
          adminPassword
        }),
      })
        .then(res => res.json())
        .then(data => {
          alert(data.message);
          if (data.success) {
            location.reload();
          }
        })
        .catch(err => console.error("Delete failed:", err));
    });
  </script>

</body>

</html>