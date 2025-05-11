<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Upload YouTube Video</title>
  <link rel="stylesheet" href="../../css/form.css">
</head>
<body>

  <!-- Shared Navbar Include -->
  <?php 
  require_once $_SERVER['DOCUMENT_ROOT'] . '/SysDevProject/config/config.php';
  require BASE_PATH . '/resources/components/navbar.php';
  ?>

  <section class="section">
    <h2>Upload YouTube Video</h2>
    <form method="post" action="?controller=video&action=upload">
        <input type="text" name="project_id" placeholder="Project ID" required><br>
        <input type="text" id="video_url" name="video_url" placeholder="YouTube Video URL" required><br>
        <input type="text" name="format" value="youtube" readonly><br>

        <!-- Automatically filled with video duration in seconds -->
        <input type="hidden" id="duration" name="duration">

        <button type="submit">Upload</button>
    </form>
  </section>

  <!-- Hidden YouTube player -->
  <div id="player" style="width:0; height:0;"></div>

  <!-- YouTube IFrame API -->
  <script src="https://www.youtube.com/iframe_api"></script>
  <script>
    let player;

    function onYouTubeIframeAPIReady() {
      const urlInput = document.getElementById('video_url');
      urlInput.addEventListener('blur', function () {
        const url = this.value.trim();
        const videoId = extractVideoId(url);
        if (!videoId) return;

        if (player) player.destroy();

        player = new YT.Player('player', {
          height: '0',
          width: '0',
          videoId: videoId,
          events: {
            'onReady': (event) => {
              const duration = event.target.getDuration();
              document.getElementById('duration').value = duration;
            }
          }
        });
      });
    }

    function extractVideoId(url) {
      const match = url.match(/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|v\/))([a-zA-Z0-9_-]{11})/);
      return match ? match[1] : null;
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