<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Delete User</title>
  <link rel="icon" type="image/png" href="/SysDevProject/public/images/logo/favicon-gear.png" />
  <link rel="stylesheet" href="../../css/deleteUser.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>

  <!-- Include shared navbar -->
  <?php 
  require_once $_SERVER['DOCUMENT_ROOT'] . '/SysDevProject/config/config.php';
  require BASE_PATH . '/resources/components/navbar.php';
  ?>

  <!-- Content -->
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

  <!-- Confirmation Modal -->
  <div id="deleteConfirmBox" class="hidden-overlay">
    <div class="confirm-content">
      <p>You are deleting user <span id="deleteUserID"></span><br>Confirm to Proceed</p>
      <div class="confirm-buttons">
        <button class="btn" onclick="hideDeleteConfirmBox()">Cancel</button>
        <button class="btn" id="confirmDeleteBtn">Confirm</button>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://www.w3schools.com/lib/w3data.js"></script>
  <script>
    w3IncludeHTML(() => {
      const logoutBtn = document.querySelector(".logout-btn");
      if (logoutBtn) {
        logoutBtn.addEventListener("click", () => {
          document.cookie = "auth=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
          window.location.href = "../login.html";
        });
      }
    });
  </script>
  <script src="../../js/deleteUser.js"></script>
</body>
</html>
