<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Change Password</title>

  <!-- Favicon and Styles -->
  <link rel="icon" type="image/png" href="/SysDevProject/public/images/logo/favicon-gear.png" />
  <link rel="stylesheet" href="../../css/userChangePassword.css">
</head>

<body>

  <!-- Include shared navigation bar -->
  <?php
  require_once dirname(__DIR__, 3) . '/vendor/autoload.php';
  $app = require_once dirname(__DIR__,3) . '/bootstrap/app.php';

  require resource_path('components/navbar.php');
  ?>

  <!-- Password Change Form -->
  <div class="form-center-wrapper">
    <div class="form-container">
    <form id="changePasswordForm" method="POST" action="?controller=user&action=changePassword">
      
      <!-- Old Password -->
      <div class="form-group">
        <label for="oldPassword">Old Password</label>
        <input type="password" id="oldPassword" name="oldPassword" required>
      </div>

      <!-- New Password -->
      <div class="form-group">
        <label for="newPassword">New Password</label>
        <input type="password" id="newPassword" name="newPassword" required>
      </div>

      <!-- Confirm New Password -->
      <div class="form-group">
        <label for="confirmPassword">Confirm Password</label>
        <input type="password" id="confirmPassword" name="confirmPassword" required>
      </div>

      <!-- Submit triggers JS confirmation -->
      <button type="submit" class="btn">Change Password</button>
    </form>
  </div>
  </div>

  <!-- Password Change Confirmation Popup -->
  <div id="changePasswordPopup" class="modal-container">
    <div class="confirm-content">
      <p>
        Are you sure you want to change your password?<br>
        This action cannot be undone.
      </p>
      <div class="confirm-buttons">
        <button type="button" class="btn" id="cancelChange">Cancel</button>
        <button type="button" class="btn" id="confirmChange">Confirm</button>
      </div>
    </div>
  </div>

  <!-- Script: handles form behavior and popup confirmation -->
  <script src="../../js/userChangePassword.js"></script>

  <!-- Logout functionality -->
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

</body>
</html>