<!DOCTYPE html>
<html lang="en">
<head>
  <!-- QR Code JS library for 2FA generation -->
  <script src="https://cdn.jsdelivr.net/gh/davidshimjs/qrcodejs/qrcode.min.js"></script>

  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?php echo _('Login - Texas Gears Engineering'); ?></title>

  <!-- Favicon for browser tab -->
  <link rel="icon" type="image/png" href="/SysDevProject/public/images/logo/favicon-gear.png" />

  <!-- Login page CSS -->
  <link rel="stylesheet" href="../../css/login.css">
</head>
<body>

  <!-- Top gradient banner for visual styling -->
  <div class="top-gradient"></div>

  <!-- Company logo centered at top -->
  <div class="header">
    <img src="../../../public/images/logo/New_TGE_Logo_2025.png" alt="Logo" class="logo">
  </div>

  <!-- Login form container -->
  <div class="login-container">
    <form id="loginForm">
      <!-- Username input field -->
      <div class="form-group">
        <label for="username"><?php echo _('Username'); ?></label>
        <input type="text" id="username" name="username"/>
      </div>

      <!-- Password input field -->
      <div class="form-group">
        <label for="password"><?php echo _('Password'); ?></label>
        <input type="password" id="password" name="password"/>
      </div>

      <!-- Login button -->
      <button type="submit" class="login-button"><?php echo _('Login'); ?></button>
    </form>

    <!-- Link to password recovery page -->
    <div class="forgot-password">
      <a href="../../views/password/forgotPassword.php"><?php echo _('Forgot password?'); ?></a>
    </div>
  </div>

  <!-- Forgot Password Confirmation Modal -->
  <div id="forgotPasswordModal" class="modal-container" style="display: none;">
    <div class="confirm-content small-popup">
      <p>
        <?php echo _('Forgetting your password as a user will send an email to the admin to change your password.
        Would you like to continue?'); ?>
      </p>

      <!-- Username input for forgot password -->
      <div class="form-group">
        <input type="text" id="forgotUsername" class="popup-input" placeholder="<?php echo _('Enter Username'); ?>" />
      </div>

      <!-- Cancel and Confirm buttons -->
      <div class="confirm-buttons">
        <button class="btn" id="cancelForgotBtn" style="background-color: #f58220; color: white;"><?php echo _('Cancel'); ?></button>
        <button class="btn" id="confirmForgotBtn" style="background-color: #f58220; color: white;"><?php echo _('Confirm'); ?></button>
      </div>
    </div>
  </div>

  <!-- Two-Factor Authentication (2FA) Modal -->
  <div id="twofaModal" class="modal-container" style="display: none;">
    <div class="confirm-content small-popup">
      <h3><?php echo _('Two-Factor Authentication'); ?></h3>
      <p><?php echo _('Scan the QR code below with your authenticator app.'); ?></p>

      <!-- Container for dynamically generated QR code -->
      <div class="qrcode" id="qrcode"></div>

      <p style="margin: 10px 0 15px;"><?php echo _('After scanning, enter the 6-digit code from your app.'); ?></p>

      <!-- Input for 2FA code -->
      <div class="form-group">
        <label for="twofaCode"><?php echo _('2FA Code'); ?></label>
        <input type="text" id="twofaCode" class="popup-input" />
      </div>

      <!-- 2FA action buttons -->
      <div class="confirm-buttons">
        <button class="btn" id="cancel2faBtn"><?php echo _('Cancel'); ?></button>
        <button class="btn" id="confirm2faBtn"><?php echo _('Confirm'); ?></button>
      </div>
    </div>
  </div>

  <!-- Login JavaScript functionality -->
  <script src="../../js/login.js"></script>
</body>
</html>