<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forgot Password</title>
  <link rel="stylesheet" href="../../css/login.css">
  <link rel="stylesheet" href="../../css/forgotPassword.css">
</head>
<body>
  <a class="top-left-link" href="login.html">← Back to Login</a>
  <div class="form-container">
    <form class="form-box" action="../../../app/Http/Controllers/authController.php?action=sendResetLink" method="POST">
      <h2>Reset Your Password</h2>
      <label for="email">Email Address</label>
      <input type="email" name="email" required />
      <button type="submit">Send Reset Link</button>
    </form>
  </div>
</body>
</html>