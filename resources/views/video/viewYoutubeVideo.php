<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>All Uploaded YouTube Videos</title>
  <!-- Link to base CSS for layout -->
  <link rel="stylesheet" href="../../css/home.css">
</head>
<body>

  <!-- Include the shared top navbar -->
  <?php
  require_once dirname(__DIR__, 3) . '/vendor/autoload.php';
  $app = require_once dirname(__DIR__,3) . '/bootstrap/app.php';

  require resource_path('components/navbar.php');
  ?>

  <!-- Section to show all uploaded YouTube videos -->
  <section class="section">
    <h2>All Uploaded YouTube Videos</h2>
    <ul id="video-list">
      <?php foreach ($videos as $index => $video): ?>
        <li>
          <!-- YouTube video player will load here dynamically -->
          <div id="player-<?= $index ?>" data-url="<?= htmlspecialchars($video->getVideoUrl()) ?>"></div>

          <!-- Show upload time -->
          Uploaded: <?= htmlspecialchars($video->getUploadTime()) ?><br>

          <!-- Delete link for this video -->
          <a href="?controller=video&action=delete&id=<?= $video->getVideoId() ?>"
             onclick="return confirm('Delete this video?')">Delete</a>
        </li>
      <?php endforeach; ?>
    </ul>
  </section>

  <!-- Load YouTube IFrame API to embed videos -->
  <script src="https://www.youtube.com/iframe_api"></script>

  <script>
    // Get the video ID from a full YouTube URL
    function extractVideoId(url) {
      const match = url.match(/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|v\/))([a-zA-Z0-9_-]{11})/);
      return match ? match[1] : null;
    }

    // When the YouTube API is ready, load each video into its div
    function onYouTubeIframeAPIReady() {
      document.querySelectorAll('[id^="player-"]').forEach(el => {
        const videoUrl = el.getAttribute('data-url');
        const videoId = extractVideoId(videoUrl);
        if (!videoId) return;

        // Create the YouTube player
        new YT.Player(el.id, {
          width: '200',
          videoId: videoId
        });
      });
    }
  </script>

  <!-- Logout functionality (shared across app) -->
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
              // Clear the session and go back to login
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