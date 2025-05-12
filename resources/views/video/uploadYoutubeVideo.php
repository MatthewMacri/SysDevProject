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
    require BASE_PATH . '/resources/components/navbar.php';
  ?>

  <!-- Upload YouTube Video Form -->
  <section class="section">
    <h2>Upload YouTube Video</h2>
    <form method="post" action="?controller=video&action=upload">
      
      <!-- Project ID -->
      <input type="text" name="project_id" placeholder="Project ID" required><br>

      <!-- YouTube URL -->
      <input type="text" id="video_url" name="video_url" placeholder="YouTube Video URL" required><br>

      <!-- Format is always 'youtube' for this form -->
      <input type="text" name="format" value="youtube" readonly><br>

      <!-- Video duration auto-filled via YouTube API -->
      <input type="hidden" id="duration" name="duration">

      <!-- Submit -->
      <button type="submit">Upload</button>
    </form>
  </section>

  <!-- Hidden YouTube Player for metadata extraction -->
  <div id="player" style="width:0; height:0;"></div>

  <!-- YouTube IFrame API -->
  <script src="https://www.youtube.com/iframe_api"></script>
  <script>
    let player;

    // Called automatically by the YouTube IFrame API
    function onYouTubeIframeAPIReady() {
      const urlInput = document.getElementById('video_url');

      urlInput.addEventListener('blur', function () {
        const videoId = extractVideoId(this.value.trim());
        if (!videoId) return;

        // Destroy previous instance if needed
        if (player) player.destroy();

        // Load new player invisibly
        player = new YT.Player('player', {
          height: '0',
          width: '0',
          videoId: videoId,
          events: {
            onReady: (event) => {
              const duration = event.target.getDuration();
              document.getElementById('duration').value = duration;
            }
          }
        });
      });
    }

    // Extracts the 11-character video ID from various YouTube URL formats
    function extractVideoId(url) {
      const match = url.match(/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|v\/))([a-zA-Z0-9_-]{11})/);
      return match ? match[1] : null;
    }
  </script>

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