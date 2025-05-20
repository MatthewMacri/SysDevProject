<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo _('Upload Video'); ?></title>

  <!-- Stylesheet -->
  <link rel="stylesheet" href="../../css/form.css">
</head>

<body>

  <!-- Include shared navigation bar -->
  <?php
  require_once dirname(__DIR__, 3) . '/vendor/autoload.php';
  $app = require_once dirname(__DIR__,3) . '/bootstrap/app.php';

  require resource_path('components/navbar.php');
  ?>

  <!-- Upload Video Form -->
  <section class="section">
    <h2><?php echo _('Upload Video'); ?></h2>
    <form method="post" action="?controller=video&action=upload">
      
      <!-- Project ID (required) -->
      <input type="text" name="project_id" placeholder="<?php echo _('Project ID'); ?>" required><br>

      <!-- Video URL -->
      <input type="text" id="video_url" name="video_url" placeholder="<?php echo _('Video URL'); ?>" required><br>

      <!-- Format (e.g., mp4) -->
      <input type="text" name="format" placeholder="<?php echo _('Format (mp4)'); ?>" required><br>

      <!-- Hidden field to capture duration using JS -->
      <input type="hidden" id="duration" name="duration">

      <!-- Submit form -->
      <button type="submit"><?php echo _('Upload'); ?></button>
    </form>
  </section>

  <!-- JavaScript to extract video duration -->
  <script>
    document.getElementById('video_url').addEventListener('blur', function () {
      const tempVideo = document.createElement('video');
      tempVideo.preload = 'metadata';
      tempVideo.src = this.value;

      // Wait for metadata to load and set duration
      tempVideo.onloadedmetadata = () => {
        document.getElementById('duration').value = tempVideo.duration;
      };
    });
  </script>

</body>
</html>