<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo _('Uploaded Photos'); ?></title>

  <!-- Main styling for layout -->
  <link rel="stylesheet" href="../../css/home.css">
</head>
<body>

  <!-- Shared navigation bar -->
  <?php
  require_once dirname(__DIR__, 3) . '/vendor/autoload.php';
  $app = require_once dirname(__DIR__,3) . '/bootstrap/app.php';

  require resource_path('components/navbar.php');
  ?>

  <!-- Section for displaying all uploaded photos -->
  <section class="section">
    <h2><?php echo _('All Uploaded Photos'); ?></h2>

    <!-- Button to open the upload form -->
    <a class="view-button" href="/SysDevProject/photo/uploadForm"><?php echo _('Upload New Photo'); ?></a>

    <!-- Loop through each photo and display details -->
    <ul>
      <?php foreach ($photos as $photo): ?>
        <li class="project-card">
          <!-- Display caption -->
          <strong><?= htmlspecialchars($photo['caption']) ?></strong><br>

          <!-- Display photo -->
          <img src="<?= htmlspecialchars($photo['photo_url']) ?>" width="200"><br>

          <!-- Metadata -->
          <?php echo _('Format'); ?>: <?= htmlspecialchars($photo['format']) ?> |
          <?php echo _('Uploaded'); ?>: <?= htmlspecialchars($photo['upload_time']) ?><br>

          <!-- Edit and Delete actions with ID passed via query string -->
          <a class="btn" href="/SysDevProject/photo/edit/<?= $photo['photo_id'] ?>"><?php echo _('Edit'); ?></a>
          <a class="btn danger" href="/SysDevProject/photo/delete/<?= $photo['photo_id'] ?>" 
             onclick="return confirm('Are you sure you want to delete this photo?')"><?php echo _('Delete'); ?></a>
        </li>
      <?php endforeach; ?>
    </ul>
  </section>

</body>
</html>