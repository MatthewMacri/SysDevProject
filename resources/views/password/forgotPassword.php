<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title><?php echo _('Forgot Password'); ?></title>

  <!-- Shared and page-specific styles -->
  <link rel="stylesheet" href="../../css/login.css">
  <link rel="stylesheet" href="../../css/forgotPassword.css">
</head>

<body>

  <!-- Navigation link to return to the login page -->
  <a class="top-left-link" href="login.html"><?php echo _('← Back to Login'); ?></a>

  <!-- Main container for the password reset form -->
  <div class="form-container">
    <form id="reset-form" class="form-box">
      <h2><?php echo _('Reset Your Password'); ?></h2>
      <label for="email"><?php echo _('Email Address'); ?></label>
      <input type="email" name="email" id="email-input" required />
      <button type="submit"><?php echo _('Send Reset Link'); ?></button>
    </form>
    <div id="feedback"></div>
    <script>
      window.addEventListener('DOMContentLoaded', function () {
        document.getElementById('reset-form').addEventListener('submit', function (e) {
          e.preventDefault();

          const email = document.getElementById('email-input').value;
          const feedback = document.getElementById('feedback');

          fetch('/resources/api/send-reset-link.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({ email })
          })
            .then(res => res.text())
            .then(data => {
              console.log("Server response:", data);
              feedback.innerHTML = `<p>${data}</p>`;
            })
            .catch(err => {
              console.error("Request failed:", err);
              feedback.innerHTML = `<p style="color:red;"><?php echo _('Request failed.'); ?></p>`;
            });
        });
      });
    </script>

</body>

</html>