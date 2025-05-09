<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>All Uploaded Videos</title>
  <link rel="stylesheet" href="../../css/home.css">
  <script src="https://www.w3schools.com/lib/w3data.js"></script>
</head>
<body>

  <!-- Shared Navbar Include -->
  <div w3-include-html="../../components/navbar.php"></div>

  <section class="section">
    <h2>All Uploaded Videos</h2>
    <a href="?controller=video&action=uploadForm">Upload New Video</a>
    <ul>
      <?php foreach ($videos as $video): ?>
        <li>
          <video height="200" controls>
            <source src="<?= htmlspecialchars($video->getVideoUrl()) ?>" type="video/<?= htmlspecialchars($video->getFormat()) ?>">
            Your browser does not support the video tag.
          </video>
          <br>
          Duration: <?= $video->getDuration() ?> seconds | Uploaded: <?= $video->getUploadTime() ?>
          <a href="?controller=video&action=delete&id=<?= $video->getVideoId() ?>" onclick="return confirm('Delete this video?')">Delete</a>
        </li>
      <?php endforeach; ?>
    </ul>
  </section>

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