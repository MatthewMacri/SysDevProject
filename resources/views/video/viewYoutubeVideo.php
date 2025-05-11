<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>All Uploaded YouTube Videos</title>
  <link rel="stylesheet" href="../../css/home.css">
</head>
<body>

  <!-- Shared Navbar Include -->
  <?php 
  require_once $_SERVER['DOCUMENT_ROOT'] . '/SysDevProject/config/config.php';
  require BASE_PATH . '/resources/components/navbar.php';
  ?>

  <section class="section">
    <h2>All Uploaded YouTube Videos</h2>
    <ul id="video-list">
      <?php foreach ($videos as $index => $video): ?>
        <li>
          <!-- YouTube player will be loaded here -->
          <div id="player-<?= $index ?>" data-url="<?= htmlspecialchars($video->getVideoUrl()) ?>"></div>
          Uploaded: <?= htmlspecialchars($video->getUploadTime()) ?><br>
          <a href="?controller=video&action=delete&id=<?= $video->getVideoId() ?>"
             onclick="return confirm('Delete this video?')">Delete</a>
        </li>
      <?php endforeach; ?>
    </ul>
  </section>

  <!-- YouTube IFrame Player API -->
  <script src="https://www.youtube.com/iframe_api"></script>

  <script>
    function extractVideoId(url) {
      const match = url.match(/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|v\/))([a-zA-Z0-9_-]{11})/);
      return match ? match[1] : null;
    }

    function onYouTubeIframeAPIReady() {
      document.querySelectorAll('[id^="player-"]').forEach(el => {
        const videoUrl = el.getAttribute('data-url');
        const videoId = extractVideoId(videoUrl);
        if (!videoId) return;

        new YT.Player(el.id, {
          width: '200',
          videoId: videoId
        });
      });
    }
  </script>

  <!-- Full Logout Script -->
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