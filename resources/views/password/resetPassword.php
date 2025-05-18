<?php
require_once dirname(__DIR__, 3) . '/vendor/autoload.php';
$app = require_once dirname(__DIR__, 3) . '/bootstrap/app.php';

require_once app_path('Http/Controllers/core/databaseController.php');

use App\Http\Controllers\core\DatabaseController;

// Establish a connection to the SQLite database
$database = DatabaseController::getInstance();
$db = $database->getConnection();
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Retrieve the token from the GET request, or terminate if not present
$token = $_GET['token'] ?? '';
if (!$token) {
    die("Invalid reset token.");
}

// Fetch the reset token data from the database
$stmt = $db->prepare("SELECT * FROM password_resets WHERE token = ?");
$stmt->execute([$token]);
$tokenData = $stmt->fetch(PDO::FETCH_ASSOC);

// Validate token existence and expiration time
if (!$tokenData || time() > $tokenData['expires_at']) {
    die("Reset link has expired or is invalid.");
}

// Handle password update if form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = password_hash($_POST['password'], PASSWORD_BCRYPT); // Securely hash the new password
    $email = $tokenData['email'];

    // Attempt to update the admin's password
    $adminUpdate = $db->prepare("UPDATE admin SET password = ? WHERE email = ?");
    $adminUpdate->execute([$newPassword, $email]);

    // If no admin was updated, attempt to update the user table instead
    if ($adminUpdate->rowCount() === 0) {
        $userUpdate = $db->prepare("UPDATE user SET password = ? WHERE email = ?");
        $userUpdate->execute([$newPassword, $email]);
    }

    // Delete the used password reset token to prevent reuse
    $db->prepare("DELETE FROM password_resets WHERE token = ?")->execute([$token]);

    // Notify user and provide link to login
    echo "Your password has been reset. You may now <a href='login.html'>login</a>.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reset Password</title>

  <!-- Shared login page styles -->
  <link rel="stylesheet" href="../../css/login.css">
</head>
<body>

  <!-- Password reset form -->
  <div class="login-container">
    <form method="POST">
      <h2>Enter New Password</h2>

      <!-- New password input -->
      <label for="password">New Password</label>
      <input type="password" name="password" required />

      <!-- Submit button to update password -->
      <button type="submit">Reset Password</button>
    </form>
  </div>

</body>
</html>