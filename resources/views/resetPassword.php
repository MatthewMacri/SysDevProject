<?php
$db = new PDO("sqlite:../../database/Datab.db");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$token = $_GET['token'] ?? '';
if (!$token) die("Invalid reset token.");

$stmt = $db->prepare("SELECT * FROM password_resets WHERE token = ?");
$stmt->execute([$token]);
$tokenData = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$tokenData || time() > $tokenData['expires_at']) {
    die("Reset link has expired or is invalid.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $tokenData['email'];

    // Try updating in admin table
    $adminUpdate = $db->prepare("UPDATE admin SET password = ? WHERE email = ?");
    $adminUpdate->execute([$newPassword, $email]);

    if ($adminUpdate->rowCount() === 0) {
        // If not in admin, try user table
        $userUpdate = $db->prepare("UPDATE user SET password = ? WHERE email = ?");
        $userUpdate->execute([$newPassword, $email]);
    }

    // Delete token
    $db->prepare("DELETE FROM password_resets WHERE token = ?")->execute([$token]);

    echo "Your password has been reset. You may now <a href='login.html'>login</a>.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reset Password</title>
  <link rel="stylesheet" href="../../resources/css/login.css">
</head>
<body>
  <div class="login-container">
    <form method="POST">
      <h2>Enter New Password</h2>
      <label for="password">New Password</label>
      <input type="password" name="password" required />
      <button type="submit">Reset Password</button>
    </form>
  </div>
</body>
</html>