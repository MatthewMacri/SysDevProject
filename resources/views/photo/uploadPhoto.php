<?php
session_start();
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
  <title>Upload Photo</title>

  <!-- Basic styling only -->
  <link rel="stylesheet" href="../../css/home.css">
  <link rel="stylesheet" href="../../css/form.css">
</head>

<body>

  <?php
  require_once dirname(__DIR__, 3) . '/vendor/autoload.php';
  $app = require_once dirname(__DIR__, 3) . '/bootstrap/app.php';

  require_once config_path('/config.php');

  // Get project_id from query string
  $projectId = isset($_GET['project_id']) ? htmlspecialchars($_GET['project_id']) : '';
  ?>

  <!-- Main form section for uploading photo data -->
  <section class="section">
    <!-- Back Button -->
    <a href="../project/CreateProjectView.php?project_id=<?= $projectId ?>"
      style="display: inline-block; margin-bottom: 15px; background-color: #ccc; padding: 8px 12px; border-radius: 4px; color: #000; text-decoration: none;">←
      Back to Create Project</a>

    <h2>Upload Photo</h2>

    <!-- Upload photo form -->
    <form method="post" action="?controller=photo&action=upload">
      <!-- Project ID -->
      <input type="text" name="project_id" placeholder="Project ID" required value="<?= $projectId ?>"><br><br>

      <!-- Photo URL -->
      <input type="text" name="photo_url" placeholder="Photo URL" required><br><br>

      <!-- Format -->
      <input type="text" name="format" placeholder="Format (jpg/png)" required><br><br>

      <!-- Caption -->
      <input type="text" name="caption" placeholder="Caption (optional)"><br><br>

      <!-- Submit -->
      <button type="submit">Upload</button>
    </form>
  </section>

</body>

</html>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/SysDevProject/resources/views/video/uploadYoutubeVideo.php';
?>