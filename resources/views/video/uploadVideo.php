<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Upload Video</title>
  <link rel="stylesheet" href="../../css/form.css">
  <script src="https://www.w3schools.com/lib/w3data.js"></script>
</head>
<body>

  <!-- Shared Navbar Include -->
  <div w3-include-html="../../components/navbar.php"></div>

  <section class="section">
    <h2>Upload Video</h2>
    <form method="post" action="?controller=video&action=upload">
      <input type="text" name="project_id" placeholder="Project ID" required><br>
      <input type="text" id="video_url" name="video_url" placeholder="Video URL" required><br>
      <input type="text" name="format" placeholder="Format (mp4)" required><br>

      <!-- Hidden duration input -->
      <input type="hidden" id="duration" name="duration">

      <button type="submit">Upload</button>
    </form>
  </section>

  <!-- Extract video duration -->
  <script>
    document.getElementById('video_url').addEventListener('blur', function () {
      const tempVideo = document.createElement('video');
      tempVideo.preload = 'metadata';
      tempVideo.src = this.value;

      tempVideo.onloadedmetadata = () => {
        document.getElementById('duration').value = tempVideo.duration;
      };
    });
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