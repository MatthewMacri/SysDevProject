<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    if (isset($_SESSION['role'])) {
      header("Location: ../home.php");
      exit;
    } 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Texas Gears Login</title>
  <link rel="stylesheet" href="../../css/login.css">
</head>
<body>
  <?php include 'login.html'; ?>
  <script src="../../js/login.js"></script>
</body>
</html>