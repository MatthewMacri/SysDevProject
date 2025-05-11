<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Archive Project</title>

  <link rel="icon" type="image/png" href="/SysDevProject/public/images/logo/favicon-gear.png" />

  <!-- Stylesheets -->
  <link rel="stylesheet" href="../../css/achive.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  
</head>
<body>

  <!-- Navbar Include -->
<?php 
  require_once $_SERVER['DOCUMENT_ROOT'] . '/SysDevProject/config/config.php';
  require BASE_PATH . '/resources/components/navbar.php';
  ?>

  <main>
    <div class="archive-form">
      <label for="serialInput" class="FormTitle">Project Serial Number<span class="required">*</span></label>
      <div class="form-content">
        <input type="text" id="serialInput" required />
        <button class="orange-btn">Archive Project</button>
      </div>
    </div>
    <p class="required-note">
      <span class="required" style="margin-left: 130px;">*</span> Required field
    </p>

    <div class="archive-list">
      <h3>List of archived projects</h3>

      <!-- Sample archived project cards -->
      <div class="project-card">
        <div>
          <div class="project-header">
            <p class="serial">Project Serial Number</p>
            <div class="status">Project Status</div>
          </div>
          <p class="title">Example Project Title</p>
          <p class="desc">Very Brief Description</p>
        </div>
        <div class="card-buttons">
          <button class="orange-btn small">History</button>
          <button class="orange-btn small">Unarchive</button>
        </div>
      </div>

      <!-- Duplicate more as needed -->
    </div>
  </main>

  <!-- Full Logout Script -->
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

  <script src="../../js/achive.js"></script>
</body>
</html>