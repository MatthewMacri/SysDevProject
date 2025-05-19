<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
  if (!isset($_SESSION['role'])) {
        header("Location: ../login/loginview.php");
        exit;
  } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Upload YouTube Video</title>

  <!-- Styles -->
  <link rel="stylesheet" href="../../css/form.css">
</head>

<body>

  <!-- Shared Navbar -->
  <?php 
    require_once $_SERVER['DOCUMENT_ROOT'] . '/SysDevProject/config/config.php';
    // require BASE_PATH . '/resources/components/navbar.php';

  use App\Http\Controllers\core\DatabaseController;
  use App\Http\Controllers\mediaControllers\VideoController;

  require_once dirname(__DIR__, 3) . '/vendor/autoload.php';
  $app = require_once dirname(__DIR__, 3) . '/bootstrap/app.php';


  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require_once app_path('Http/Controllers/core/databaseController.php');
    require_once app_path('Http/Controllers/mediaControllers/videocontroller.php');
    $db = DatabaseController::getInstance();

    $videoController = new VideoController($db);
    
    $videoController->upload($_POST);

  }
  ?>

  <!-- Upload YouTube Video Form -->
  <section class="section">
    <h2>Upload YouTube Video</h2>
    <form method="post" action="">
      
      <!-- Project ID -->
      <input type="text" name="project_id" placeholder="Project ID" required><br>
      <br>
      <!-- YouTube URL -->
      <input type="text" id="video_url" name="video_url" placeholder="YouTube Video URL" required><br>
      <!-- Format is always 'youtube' for this form -->
      <input type="hidden" name="format" value="youtube" readonly><br>

      <input type="number" id="duration" name="duration" placeholder="Enter Duration (seconds)" min="1" max="10000" required style="width: 165px;">
      <br><br>
      <button type="submit">Upload</button>
    </form>
  </section>

  


  <!-- Full Logout Script -->
  <script src="https://www.w3schools.com/lib/w3data.js"></script>
  <script>
    w3IncludeHTML(function () {
      const logoutBtn = document.querySelector(".logout-btn");
      if (logoutBtn) {
        logoutBtn.addEventListener("click", () => {
          fetch("/SysDevProject/logout.php", {
            method: "POST",
            credentials: "include"
          })
          .then(res => res.json())
          .then(data => {
            if (data.success) {
              document.cookie = "auth=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
              window.location.href = "/SysDevProject/resources/views/login.html";
            } else {
              alert("Logout failed");
            }
          })
          .catch(err => {
            console.error("Logout error:", err);
            alert("Logout request failed.");
          });
        });
      }
    });
  </script>

</body>
</html>