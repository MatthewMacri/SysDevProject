<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Uploaded Photos</title>

  <!-- Main styling for layout -->
  <link rel="stylesheet" href="../../css/home.css">
</head>
<body>

  <!-- Shared navigation bar -->
  <?php 
    require_once $_SERVER['DOCUMENT_ROOT'] . '/SysDevProject/config/config.php';
    require BASE_PATH . '/resources/components/navbar.php';
  ?>

  <!-- Section for displaying all uploaded photos -->
  <section class="section">
    <h2>All Uploaded Photos</h2>

    <!-- Button to open the upload form -->
    <a class="view-button" href="?controller=photo&action=uploadForm">Upload New Photo</a>

    <!-- Loop through each photo and display details -->
    <ul>
      <?php foreach ($photos as $photo): ?>
        <li class="project-card">
          <!-- Display caption -->
          <strong><?= htmlspecialchars($photo['caption']) ?></strong><br>

          <!-- Display photo -->
          <img src="<?= htmlspecialchars($photo['photo_url']) ?>" width="200"><br>

          <!-- Metadata -->
          Format: <?= htmlspecialchars($photo['format']) ?> |
          Uploaded: <?= htmlspecialchars($photo['upload_time']) ?><br>

          <!-- Edit and Delete actions with ID passed via query string -->
          <a class="btn" href="?controller=photo&action=edit&id=<?= $photo['photo_id'] ?>">Edit</a>
          <a class="btn danger" href="?controller=photo&action=delete&id=<?= $photo['photo_id'] ?>" 
             onclick="return confirm('Are you sure you want to delete this photo?')">Delete</a>
        </li>
      <?php endforeach; ?>
    </ul>
  </section>

  <!-- Logout logic using Fetch API -->
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