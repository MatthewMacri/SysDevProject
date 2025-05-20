<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo _('Project Details'); ?></title>

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="/SysDevProject/public/images/logo/favicon-gear.png" />

  <!-- Custom and external styles -->
  <link rel="stylesheet" href="../../css/deleteProject.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

  <!-- Include shared navbar -->
  <?php
  require_once dirname(__DIR__, 3) . '/vendor/autoload.php';
  $app = require_once dirname(__DIR__,3) . '/bootstrap/app.php';

  require resource_path('components/navbar.php');
  ?>

  <main>
    <!-- Project Header Section -->
    <div class="project-header">
      <div>
        <h2 class="project-title" id="projectTitle"><?php echo _('Lorem Ipsum Project'); ?></h2>
        <p class="project-id" id="projectSerial"><?php echo _('Project U-1234567'); ?></p>
      </div>
      <div class="project-status" id="projectStatus"><?php echo _('Project Status'); ?></div>
    </div>

    <!-- Project Description -->
    <div class="project-description" id="projectDescription">
      <p><?php echo _('Project Details: Lorem ipsum dolor sit amet, consectetur adipiscing elit...'); ?></p>
    </div>

    <!-- Project Metadata -->
    <div class="gray-box">
      <p id="clientDetails"><?php echo _('Client Details: lorem ipsum'); ?></p>
      <p id="supplierInfo"><?php echo _('Supplier Info: '); ?></p>
      <p id="supplierDate"><?php echo _('Supplier date: 2025-01-02'); ?></p>
      <p id="clientDate"><?php echo _('Client date: 2025-03-02'); ?></p>
      <p id="bufferDays"><?php echo _('Buffer days (slack time): 5 days'); ?></p>
    </div>

    <!-- Related Views Section -->
    <div class="media-section">
      <button class="media-button"> <?php echo _('Project Media'); ?><i class="fas fa-image"></i></button>
      <button class="media-button"><?php echo _('KanBan Board'); ?> <i class="fas fa-table-columns"></i></button>
      <button class="media-button"><?php echo _('Gantt Chart'); ?> <i class="fas fa-chart-bar"></i></button>
    </div>

    <!-- Delete Confirmation Form -->
    <form method="POST" action="/SysDevProject/project/delete">
      <div class="form-actions">
        <button type="button" class="form-button cancel-button"><?php echo _('Cancel'); ?></button>
        <button type="submit" class="form-button delete-button"><?php echo _('Delete'); ?></button>
      </div>
    </form>
  </main>

  <!-- Delete Confirmation Modal -->
  <div class="popup-overlay" id="popup">
    <div class="popup-box">
      <p><?php echo _('You are attempting to DELETE a project. Please make sure the information provided is correct.'); ?></p>
      <input type="password" placeholder="Enter your password and confirm" id="passwordInput">
      <div class="popup-buttons">
        <button id="cancelPopup" class="orange-btn"><?php echo _('Cancel'); ?></button>
        <button id="confirmPopup" class="orange-btn"><?php echo _('Confirm'); ?></button>
      </div>
    </div>
  </div>

  <!-- Logout + Custom Script -->
  <script src="https://www.w3schools.com/lib/w3data.js"></script>
  <script>
    // Logout functionality
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

  <!-- Project delete logic (confirmation modal, password check, etc.) -->
  <script src="../../js/deleteproject.js"></script>
</body>
</html>