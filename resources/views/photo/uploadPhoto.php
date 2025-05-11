<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Upload Photo</title>

  <!-- Styles for layout, navbar, and forms -->
  <link rel="stylesheet" href="../../css/home.css">
  <link rel="stylesheet" href="../../css/navbar.css">
  <link rel="stylesheet" href="../../css/form.css">
</head>
<body>

  <!-- Include the shared navigation bar -->
  <?php 
    require_once $_SERVER['DOCUMENT_ROOT'] . '/SysDevProject/config/config.php';
    require BASE_PATH . '/resources/components/navbar.php';
  ?>

  <!-- Main form section for uploading photo data -->
  <section class="section">
    <h2>Upload Photo</h2>

    <!-- Upload photo form, sends data to the controller using MVC pattern -->
    <form method="post" action="?controller=photo&action=upload">
      <!-- Project ID field (required) -->
      <input type="text" name="project_id" placeholder="Project ID" required><br>

      <!-- Photo URL field (required) -->
      <input type="text" name="photo_url" placeholder="Photo URL" required><br>

      <!-- Format field (required, e.g., jpg/png) -->
      <input type="text" name="format" placeholder="Format (jpg/png)" required><br>

      <!-- Optional caption -->
      <input type="text" name="caption" placeholder="Caption"><br>

      <!-- Submit button -->
      <button type="submit">Upload</button>
    </form>
  </section>

  <!-- Logout functionality using fetch (AJAX) -->
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
              // Clear cookie and redirect to login page
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