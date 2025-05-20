<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo _('Change Password'); ?></title>

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
    <form id="changePasswordForm" method="POST" action="/SysDevProject/user/changePassword">
      
      <!-- Old Password -->
      <div class="form-group">
        <label for="oldPassword"><?php echo _('Old Password'); ?></label>
        <input type="password" id="oldPassword" name="oldPassword" required>
      </div>

      <!-- New Password -->
      <div class="form-group">
        <label for="newPassword"><?php echo _('New Password'); ?></label>
        <input type="password" id="newPassword" name="newPassword" required>
      </div>

      <!-- Confirm New Password -->
      <div class="form-group">
        <label for="confirmPassword"><?php echo _('Confirm Password'); ?></label>
        <input type="password" id="confirmPassword" name="confirmPassword" required>
      </div>

      <!-- Submit triggers JS confirmation -->
      <button type="submit" class="btn"><?php echo _('Change Password'); ?></button>
    </form>
  </div>
  </div>

  <!-- Password Change Confirmation Popup -->
  <div id="changePasswordPopup" class="modal-container">
    <div class="confirm-content">
      <p>
        <?php echo _('Are you sure you want to change your password?'); ?><br>
        <?php echo _('This action cannot be undone.'); ?>
      </p>
      <div class="confirm-buttons">
        <button type="button" class="btn" id="cancelChange"><?php echo _('Cancel'); ?></button>
        <button type="button" class="btn" id="confirmChange"><?php echo _('Confirm'); ?></button>
      </div>
    </div>
  </div>

  <!-- Script: handles form behavior and popup confirmation -->
  <script src="../../js/userChangePassword.js"></script>
  
</body>
</html>