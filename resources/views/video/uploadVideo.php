<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Upload Video</title>

  <!-- Stylesheet -->
  <link rel="stylesheet" href="../../css/form.css">
</head>

<body>

  <!-- Include shared navigation bar -->
  <?php 
    require_once $_SERVER['DOCUMENT_ROOT'] . '/SysDevProject/config/config.php';
    require BASE_PATH . '/resources/components/navbar.php';
  ?>

  <!-- Upload Video Form -->
  <section class="section">
    <h2>Upload Video</h2>
    <form method="post" action="?controller=video&action=upload">
      
      <!-- Project ID (required) -->
      <input type="text" name="project_id" placeholder="Project ID" required><br>

      <!-- Video URL -->
      <input type="text" id="video_url" name="video_url" placeholder="Video URL" required><br>

      <!-- Format (e.g., mp4) -->
      <input type="text" name="format" placeholder="Format (mp4)" required><br>

      <!-- Hidden field to capture duration using JS -->
      <input type="hidden" id="duration" name="duration">

      <!-- Submit form -->
      <button type="submit">Upload</button>
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

  <!-- Full Logout Support -->
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