<?php
require_once dirname(__DIR__, 3) . '/vendor/autoload.php';
$app = require_once dirname(__DIR__, 3) . '/bootstrap/app.php';

use App\Http\Controllers\core\DatabaseController;

$db = DatabaseController::getInstance();

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

  <!-- Link to login page CSS for styling -->
  <link rel="stylesheet" href="../../css/login.css">
</head>
<body>

  <!-- Include static login form content (HTML page) -->
  <?php include 'login.html';  ?>

  <!-- Link to login functionality (JS) -->
  <script src="../../js/login.js"></script>
</body>
</html>