<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forgot Password</title>

  <!-- Shared and page-specific styles -->
  <link rel="stylesheet" href="../../css/login.css">
  <link rel="stylesheet" href="../../css/forgotPassword.css">
</head>
<body>

  <!-- Navigation link to return to the login page -->
  <a class="top-left-link" href="login.html">← Back to Login</a>

  <!-- Main container for the password reset form -->
  <div class="form-container">
    <form class="form-box"
          action="../../../app/Http/Controllers/authController.php?action=sendResetLink"
          method="POST">
      
      <!-- Heading -->
      <h2>Reset Your Password</h2>

      <!-- Email input field for password reset -->
      <label for="email">Email Address</label>
      <input type="email" name="email" required />

      <!-- Submit button to request a password reset -->
      <button type="submit">Send Reset Link</button>
    </form>
  </div>

</body>
</html>