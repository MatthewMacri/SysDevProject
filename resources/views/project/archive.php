<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title><?php echo _('Admin Archive Project'); ?></title>

  <!-- Favicon for branding -->
  <link rel="icon" type="image/png" href="/SysDevProject/public/images/logo/favicon-gear.png" />

  <!-- Custom and external stylesheets -->
  <link rel="stylesheet" href="../../css/achive.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>

<body>

  <!-- Include shared navigation bar -->
  <?php
  require_once dirname(__DIR__, 3) . '/vendor/autoload.php';
  $app = require_once dirname(__DIR__,3) . '/bootstrap/app.php';

  require resource_path('components/navbar.php');
  ?>

  <!-- Main content area -->
  <main>
    <!-- Archive Project Form -->
    <div class="archive-form">
      <label for="serialInput" class="FormTitle">
        <?php echo _('Project Serial Number'); ?><span class="required">*</span>
      </label>
      <div class="form-content">
        <input type="text" id="serialInput" required />
        <button class="orange-btn"><?php echo _('Archive Project'); ?></button>
      </div>
    </div>

    <!-- Required field note -->
    <p class="required-note">
      <span class="required" style="margin-left: 130px;">*</span><?php echo _('Required field'); ?>
    </p>

    <!-- Archived Projects List -->
    <div class="archive-list">
      <h3><?php echo _('List of Archived Projects'); ?></h3>

      <!-- Example archived project card -->
      <div class="project-card">
        <div>
          <div class="project-header">
            <p class="serial"><?php echo _('Project Serial Number'); ?></p>
            <div class="status"><?php echo _('Project Status'); ?></div>
          </div>
          <p class="title"><?php echo _('Example Project Title'); ?></p>
          <p class="desc"><?php echo _('Very Brief Description'); ?></p>
        </div>
        <div class="card-buttons">
          <button class="orange-btn small"><?php echo _('History'); ?></button>
          <button class="orange-btn small"><?php echo _('Unarchive'); ?></button>
        </div>
      </div>

      <!-- Additional cards can be dynamically rendered -->
    </div>
  </main>

  <!-- Logout script using fetch() -->
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

  <!-- Archive project JavaScript logic -->
  <script src="../../js/achive.js"></script>
</body>
</html>