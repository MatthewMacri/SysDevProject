<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Uploaded Photos</title>
  <link rel="stylesheet" href="../../css/home.css">
  <script src="https://www.w3schools.com/lib/w3data.js"></script>
</head>
<body>

<!-- Navbar -->
<div w3-include-html="../../components/navbar.php"></div>

<section class="section">
  <h2>All Uploaded Photos</h2>
  <a class="view-button" href="?controller=photo&action=uploadForm">Upload New Photo</a>
  <ul>
    <?php foreach ($photos as $photo): ?>
      <li class="project-card">
        <strong><?= htmlspecialchars($photo['caption']) ?></strong><br>
        <img src="<?= htmlspecialchars($photo['photo_url']) ?>" width="200"><br>
        Format: <?= htmlspecialchars($photo['format']) ?> |
        Uploaded: <?= htmlspecialchars($photo['upload_time']) ?>
      </li>
    <?php endforeach; ?>
  </ul>
</section>

<!-- Logout Script -->
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