<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin List</title>
  
  <!-- Link to the stylesheet for the Admin List page -->
  <link rel="stylesheet" href="../../css/listAdmins.css">
</head>

<body>
  <!-- Load shared Navbar -->
  <?php 
    // Including the shared navbar for navigation
    require_once $_SERVER['DOCUMENT_ROOT'] . '/SysDevProject/config/config.php';
    require BASE_PATH . '/resources/components/navbar.php';
  ?>

  <!-- Main Content Section for Admin List -->
  <section class="section">
    <h2>Admin List</h2>
    
    <!-- Button to add a new admin -->
    <a class="view-button" href="?controller=admin&action=create">Add Admin</a>
    
    <!-- List of Admins -->
    <ul class="admin-list">
      <?php foreach ($admins as $admin): ?>
        <li class="admin-card">
          <!-- Display each admin's name and email -->
          <strong><?= htmlspecialchars($admin['admin_name']) ?></strong><br>
          <?= htmlspecialchars($admin['email']) ?>
        </li>
      <?php endforeach; ?>
    </ul>
  </section>

  <!-- Script for Logout Functionality -->
  <script src="https://www.w3schools.com/lib/w3data.js"></script>
  <script>
    w3IncludeHTML(function () {
      const logoutBtn = document.querySelector(".logout-btn");
      
      // Add an event listener to the logout button
      if (logoutBtn) {
        logoutBtn.addEventListener("click", () => {
          fetch("/SysDevProject/logout.php", {
            method: "POST",
            credentials: "include"
          })
          .then(res => res.json())
          .then(data => {
            if (data.success) {
              // Clear authentication cookie and redirect to login page
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