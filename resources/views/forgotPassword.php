<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forgot Password</title>
<link rel="stylesheet" href="../../resources/css/forgotPassword.css">
</head>
<body>
  <div class="login-container">
    <form action="send-reset-link.php" method="POST">
      <h2>Reset Your Password</h2>
      <label for="email">Email Address</label>
      <input type="email" name="email" required />
      <button type="submit">Send Reset Link</button>
    </form>
  </div>
</body>
</html>