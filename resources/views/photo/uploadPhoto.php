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
  <title><?php echo _('Upload Photo'); ?></title>

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
      <?php echo _('Back to Create Project'); ?></a>

    <h2>Upload Photo</h2>

    <!-- Upload photo form -->
    <form method="post" action="/SysDevProject/photo/upload">
      <!-- Project ID -->
      <input type="text" name="project_id" placeholder="<?php echo _('Project ID'); ?>" required value="<?= $projectId ?>"><br><br>

      <!-- Photo URL -->
      <input type="text" name="photo_url" placeholder="<?php echo _('Photo URL'); ?>" required><br><br>

      <!-- Format -->
      <input type="text" name="format" placeholder="<?php echo _('Format (jpg/png)'); ?>" required><br><br>

      <!-- Caption -->
      <input type="text" name="caption" placeholder="<?php echo _('Caption (optional)'); ?>"><br><br>

      <!-- Submit -->
      <button type="submit"><?php echo _('Upload'); ?></button>
    </form>
  </section>

</body>

</html>

<?php
require_once dirname(__DIR__, 3) . '/vendor/autoload.php';
$app = require_once dirname(__DIR__, 3) . '/bootstrap/app.php';
require_once resource_path('views/video/uploadYoutubeVideo.php');
?>