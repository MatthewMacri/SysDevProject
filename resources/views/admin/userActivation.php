<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?php echo _('User Activation'); ?></title>

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="/SysDevProject/public/images/logo/favicon-gear.png" />

  <!-- Stylesheets -->
  <link rel="stylesheet" href="../../css/userActivation.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>

  <!-- Include the shared navigation bar component -->
  <?php
  require_once dirname(__DIR__, 3) . '/vendor/autoload.php';
  $app = require_once dirname(__DIR__,3) . '/bootstrap/app.php';

  require resource_path('components/navbar.php');
  ?>

  <!-- Main form container for activating or deactivating a user -->
  <div class="form-container">
    <div class="form-box">
      <!-- Input field for the target username -->
      <label for="username">Username</label>
      <input type="text" id="username" placeholder="TGUser" />

      <!-- Input field for the admin's password for authentication -->
      <label for="admin-password">Admin Password</label>
      <input type="password" id="admin-password" placeholder="Value" />

      <!-- Action buttons to activate or deactivate user -->
      <div class="buttons">
        <button class="activateButton">Activate User</button>
        <button class="deactivateButton">Deactivate User</button>
      </div>
    </div>
  </div>

  <!-- Modal for confirming user activation -->
  <div id="confirmBox" class="hidden-overlay">
    <div class="confirm-content">
      <p>
        You are activating user <span id="activateUserID"></span><br>
        Confirm to Proceed
      </p>
      <div class="confirm-buttons">
        <button class="btn" id="cancelActivate">Cancel</button>
        <button class="btn" id="confirmActivate">Confirm</button>
      </div>
    </div>
  </div>

  <!-- Modal for confirming user deactivation -->
  <div id="deactivateConfirmBox" class="hidden-overlay">
    <div class="confirm-content">
      <p>
        You are deactivating user <span id="deactivateUserID"></span><br>
        Confirm to Proceed
      </p>
      <div class="confirm-buttons">
        <button class="btn" id="cancelDeactivate">Cancel</button>
        <button class="btn" id="confirmDeactivate">Confirm</button>
      </div>
    </div>
  </div>

  <!-- JavaScript logic for user activation functionality -->
  <script src="../../js/userActivation.js"></script>

  <!-- Include W3Schools library for HTML includes -->
  <script src="https://www.w3schools.com/lib/w3data.js"></script>

  <!-- Logout handler using a click event -->
  <script>
    w3IncludeHTML(() => {
      const logoutBtn = document.querySelector(".logout-btn");
      if (logoutBtn) {
        logoutBtn.addEventListener("click", () => {
          // Clear the auth cookie and redirect to login page
          document.cookie = "auth=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
          window.location.href = "../login.html";
        });
      }
    });
  </script>



</body>
</html>