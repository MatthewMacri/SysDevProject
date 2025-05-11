<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Upload Photo</title>
  <link rel="stylesheet" href="../../css/home.css">
  <link rel="stylesheet" href="../../css/navbar.css">
  <link rel="stylesheet" href="../../css/form.css">
</head>
<body>

<!-- Navbar -->
<?php 
  require_once $_SERVER['DOCUMENT_ROOT'] . '/SysDevProject/config/config.php';
  require BASE_PATH . '/resources/components/navbar.php';
  ?>

<section class="section">
  <h2>Upload Photo</h2>
  <form method="post" action="?controller=photo&action=upload">
      <input type="text" name="project_id" placeholder="Project ID" required><br>
      <input type="text" name="photo_url" placeholder="Photo URL" required><br>
      <input type="text" name="format" placeholder="Format (jpg/png)" required><br>
      <input type="text" name="caption" placeholder="Caption"><br>
      <button type="submit">Upload</button>
  </form>
</section>

<!-- Logout Script -->
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