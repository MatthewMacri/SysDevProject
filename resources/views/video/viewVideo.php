<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>All Uploaded Videos</title>
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
    <h2>All Uploaded Videos</h2>

    <!-- Button to navigate to upload form -->
    <a href="?controller=video&action=uploadForm">Upload New Video</a>

    <ul>
      <!-- Loop through each video and display it -->
      <?php foreach ($videos as $video): ?>
        <li>
          <!-- Video player -->
          <video height="200" controls>
            <source src="<?= htmlspecialchars($video->getVideoUrl()) ?>" type="video/<?= htmlspecialchars($video->getFormat()) ?>">
            Your browser does not support the video tag.
          </video>
          <br>

          <!-- Video metadata: duration and upload time -->
          Duration: <?= $video->getDuration() ?> seconds | Uploaded: <?= $video->getUploadTime() ?>

          <!-- Delete link with confirmation -->
          <a href="?controller=video&action=delete&id=<?= $video->getVideoId() ?>" onclick="return confirm('Delete this video?')">Delete</a>
        </li>
      <?php endforeach; ?>
    </ul>
  </section>

  <!-- Logout functionality script -->
  <script>
    w3IncludeHTML(function () {
      const logoutBtn = document.querySelector(".logout-btn");
      if (logoutBtn) {
        logoutBtn.addEventListener("click", () => {
          // Send logout request to server
          fetch("/SysDevProject/logout.php", {
            method: "POST",
            credentials: "include"
          })
          .then(res => res.json())
          .then(data => {
            if (data.success) {
              // Clear session cookie and redirect to login page
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