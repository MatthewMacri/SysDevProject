<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Change Password</title>

  <link rel="icon" type="image/png" href="/SysDevProject/public/images/logo/favicon-gear.png" />

  <!-- Stylesheets -->
  <link rel="stylesheet" href="../../css/adminChangePassword.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>

  <!-- Shared Navbar Include -->
  <?php 
  require_once $_SERVER['DOCUMENT_ROOT'] . '/SysDevProject/config/config.php';
  require BASE_PATH . '/resources/components/navbar.php';
  ?>

  <!-- Form Content -->
  <div class="form-container">
    <div class="form-box">
      <label for="username">Username</label>
      <input type="text" id="username" placeholder="Value" />

      <label for="new-password">New Password</label>
      <input type="password" id="new-password" placeholder="Value" />

      <div class="button-center">
        <button class="changePasswordButton">Change Password</button>
      </div>
    </div>
  </div>

  <!-- Popup -->
  <div id="changePasswordPopup" class="hidden-overlay">
    <div class="confirm-content">
      <p>
        You are changing the password for user <span id="changeUserID"></span>.<br>
        Please make sure to save the password in a safe place!
      </p>
      <input type="password" id="adminConfirmPassword" placeholder="Enter Admin Password" class="popup-input" />
      <div class="confirm-buttons">
        <button class="btn" onclick="hideChangePasswordPopup()">Cancel</button>
        <button class="btn">Confirm</button>
      </div>
    </div>
  </div>

  <!-- Scripts -->
   <script src="https://www.w3schools.com/lib/w3data.js"></script>
  <script>
    w3IncludeHTML(function () {
      const logoutBtn = document.querySelector(".logout-btn");
      if (logoutBtn) {
        logoutBtn.addEventListener("click", () => {
          fetch("/SysDevProject/logout.php", {
            method: "POST",
            credentials: "include"
          })
          .then(res => res.json())
          .then(data => {
            if (data.success) {
              document.cookie = "auth=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
              window.location.href = "/SysDevProject/resources/views/login.html";
            } else {
              alert("Logout failed");
            }
          })
          .catch(err => {
            console.error("Logout error:", err);
            alert("Logout request failed.");
          });
        });
      }
    });
  </script>
  <script src="../../js/adminChangePass.js"></script>
</body>
</html>