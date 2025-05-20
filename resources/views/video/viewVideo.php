<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo _('All Uploaded Videos'); ?></title>
  <!-- Main CSS styling -->
  <link rel="stylesheet" href="../../css/home.css">
</head>
<body>

  <!-- Include the shared top navigation bar -->
  <?php
  require_once dirname(__DIR__, 3) . '/vendor/autoload.php';
  $app = require_once dirname(__DIR__,3) . '/bootstrap/app.php';

  require resource_path('components/navbar.php');
  ?>

  <!-- Main content section -->
  <section class="section">
    <h2><?php echo _('All Uploaded Videos'); ?></h2>

    <!-- Button to navigate to upload form -->
    <a href="?controller=video&action=uploadForm"><?php echo _('Upload New Video'); ?></a>

    <ul>
      <!-- Loop through each video and display it -->
      <?php foreach ($videos as $video): ?>
        <li>
          <!-- Video player -->
          <video height="200" controls>
            <source src="<?= htmlspecialchars($video->getVideoUrl()) ?>" type="video/<?= htmlspecialchars($video->getFormat()) ?>">
            <?php echo _('Your browser does not support the video tag.'); ?>
          </video>
          <br>

          <!-- Video metadata: duration and upload time -->
          <?php echo _('Duration'); ?>: <?= $video->getDuration() ?> <?php echo _('seconds | Uploaded'); ?>: <?= $video->getUploadTime() ?>

          <!-- Delete link with confirmation -->
          <a href="?controller=video&action=delete&id=<?= $video->getVideoId() ?>" onclick="return confirm('Delete this video?')"><?php echo _('Delete'); ?></a>
        </li>
      <?php endforeach; ?>
    </ul>
  </section>

</body>
</html>