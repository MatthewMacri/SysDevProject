<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Photo</title>
  <link rel="stylesheet" href="../../css/home.css">
  <link rel="stylesheet" href="../../css/navbar.css">
  <link rel="stylesheet" href="../../css/form.css">
  <script src="https://www.w3schools.com/lib/w3data.js"></script>
</head>
<body>

<!-- Navbar -->
<div w3-include-html="../../components/navbar.php"></div>

<section class="section">
  <h2>Edit Photo</h2>
  <form method="post" action="?controller=photo&action=update&id=<?= $photo['photo_id'] ?>">
      <input type="text" name="project_id" value="<?= htmlspecialchars($photo['project_id']) ?>" required><br>
      <input type="text" name="photo_url" value="<?= htmlspecialchars($photo['photo_url']) ?>" required><br>
      <input type="text" name="format" value="<?= htmlspecialchars($photo['format']) ?>" required><br>
      <input type="text" name="caption" value="<?= htmlspecialchars($photo['caption']) ?>"><br>
      <button type="submit">Update Photo</button>
  </form>
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