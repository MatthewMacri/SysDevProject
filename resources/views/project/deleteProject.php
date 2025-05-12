<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Project Details</title>

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="/SysDevProject/public/images/logo/favicon-gear.png" />

  <!-- Custom and external styles -->
  <link rel="stylesheet" href="../../css/deleteProject.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

  <!-- Include shared navbar -->
  <?php 
    require_once $_SERVER['DOCUMENT_ROOT'] . '/SysDevProject/config/config.php';
    require BASE_PATH . '/resources/components/navbar.php';
  ?>

  <main>
    <!-- Project Header Section -->
    <div class="project-header">
      <div>
        <h2 class="project-title" id="projectTitle">Lorem Ipsum Project</h2>
        <p class="project-id" id="projectSerial">Project U-1234567</p>
      </div>
      <div class="project-status" id="projectStatus">Project Status</div>
    </div>

    <!-- Project Description -->
    <div class="project-description" id="projectDescription">
      <p>Project Details: Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
    </div>

    <!-- Project Metadata -->
    <div class="gray-box">
      <p id="clientDetails">Client Details: lorem ipsum</p>
      <p id="supplierInfo">Supplier Info: </p>
      <p id="supplierDate">Supplier date: 2025-01-02</p>
      <p id="clientDate">Client date: 2025-03-02</p>
      <p id="bufferDays">Buffer days (slack time): 5 days</p>
    </div>

    <!-- Related Views Section -->
    <div class="media-section">
      <button class="media-button">Project Media <i class="fas fa-image"></i></button>
      <button class="media-button">KanBan Board <i class="fas fa-table-columns"></i></button>
      <button class="media-button">Gantt Chart <i class="fas fa-chart-bar"></i></button>
    </div>

    <!-- Delete Confirmation Form -->
    <form method="POST" action="?controller=project&action=delete">
      <div class="form-actions">
        <button type="button" class="form-button cancel-button">Cancel</button>
        <button type="submit" class="form-button delete-button">Delete</button>
      </div>
    </form>
  </main>

  <!-- Delete Confirmation Modal -->
  <div class="popup-overlay" id="popup">
    <div class="popup-box">
      <p>You are attempting to DELETE a project. Please make sure the information provided is correct.</p>
      <input type="password" placeholder="Enter your password and confirm" id="passwordInput">
      <div class="popup-buttons">
        <button id="cancelPopup" class="orange-btn">Cancel</button>
        <button id="confirmPopup" class="orange-btn">Confirm</button>
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