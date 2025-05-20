<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo _('Change Password'); ?></title>

  <link rel="icon" type="image/png" href="/SysDevProject/public/images/logo/favicon-gear.png" />
  <link rel="stylesheet" href="../../css/adminChangePassword.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>

<body>

  <?php
  require_once dirname(__DIR__, 3) . '/vendor/autoload.php';
  require_once dirname(__DIR__, 3) . '/bootstrap/app.php';

  require resource_path('components/navbar.php');
  ?>

  <form action="?controller=user&action=changePassword" method="post">
    <div class="form-box">
      <label for="username"><?php echo _('Username'); ?></label>
      <input type="text" id="username" name="username" placeholder="Value" required />

      <label for="new-password"><?php echo _('New Password'); ?></label>
      <input type="password" id="new-password" name="new_password" placeholder="Value" required />

      <div class="button-center">
        <button type="submit" class="changePasswordButton"><?php echo _('Change Password'); ?></button>
      </div>
    </div>
  </form>

  <div id="changePasswordPopup" class="hidden-overlay">
    <div class="confirm-content">
      <p>
        <?php echo _('You are changing the password for user'); ?>
        <span id="changeUserID"></span>.<br>
        <?php echo _('Please make sure to save the password in a safe place!'); ?>
      </p>
      <input type="password" id="adminConfirmPassword" placeholder="Enter Admin Password" class="popup-input" />
      <div class="confirm-buttons">
        <button class="btn" id="cancelChange" onclick="hideChangePasswordPopup()"><?php echo _('Cancel'); ?></button>
        <button class="btn" id="confirmChange"><?php echo _('Confirm'); ?></button>
      </div>
    </div>
  </div>

  <script src="/SysDevProject/resources/js/adminChangePass.js"></script>
</body>

</html>