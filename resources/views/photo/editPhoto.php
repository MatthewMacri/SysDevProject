<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo _('Edit Photo'); ?></title>

  <!-- Stylesheets for layout, navigation, and form design -->
  <link rel="stylesheet" href="../../css/home.css">
  <link rel="stylesheet" href="../../css/navbar.css">
  <link rel="stylesheet" href="../../css/form.css">
</head>

<body>

<!-- Include shared navigation bar -->
<?php
  require_once dirname(__DIR__, 3) . '/vendor/autoload.php';
  $app = require_once dirname(__DIR__,3) . '/bootstrap/app.php';

  require resource_path('components/navbar.php');
  ?>

<!-- Main section: Edit Photo Form -->
<section class="section">
  <h2><?php echo _('Edit Photo'); ?></h2>

  <!-- Form for updating photo details -->
  <form method="post" action="/SysDevProject/photo/update/<?= htmlspecialchars($photo['photo_id']) ?>">

    <!-- Project ID (linked to the photo) -->
    <label><?php echo _('Project ID'); ?></label>
    <input type="text" name="project_id" value="<?= htmlspecialchars($photo['project_id']) ?>" required><br>

    <!-- Photo URL -->
    <label><?php echo _('Photo URL'); ?></label>
    <input type="text" name="photo_url" value="<?= htmlspecialchars($photo['photo_url']) ?>" required><br>

    <!-- Format (e.g., JPG, PNG) -->
    <label><?php echo _('Format'); ?></label>
    <input type="text" name="format" value="<?= htmlspecialchars($photo['format']) ?>" required><br>

    <!-- Optional caption -->
    <label><?php echo _('Caption'); ?></label>
    <input type="text" name="caption" value="<?= htmlspecialchars($photo['caption']) ?>"><br>

    <!-- Submit button -->
    <button type="submit"><?php echo _('Update Photo'); ?></button>
  </form>
</section>

<!-- Logout handler script (via Fetch API) -->
<script src="https://www.w3schools.com/lib/w3data.js"></script>
<script>
  w3IncludeHTML(function () {
    const logoutBtn = document.querySelector(".logout-btn");
    if (logoutBtn) {
      logoutBtn.addEventListener("click", () => {
        // Send logout request via POST
        fetch("/SysDevProject/logout.php", {
          method: "POST",
          credentials: "include"
        })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            // Clear auth cookie and redirect to login
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