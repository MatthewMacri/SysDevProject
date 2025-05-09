<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
  header("Location: login.html");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Texas Gears Dashboard</title>

  <!-- Stylesheets -->
  <link rel="stylesheet" href="../css/navbar.css">
  <link rel="stylesheet" href="../css/home.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/24.2.6/css/dx-gantt.min.css">
  <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/24.2.6/css/dx.light.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jkanban@1.3.1/dist/jkanban.min.css">

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://www.w3schools.com/lib/w3data.js"></script>
  <script src="https://cdn3.devexpress.com/jslib/24.2.6/js/dx-gantt.min.js"></script>
  <script src="https://cdn3.devexpress.com/jslib/24.2.6/js/dx.all.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jkanban@1.3.1/dist/jkanban.min.js"></script>

  <!-- Project Scripts -->
  <script src="../static_data/data.js"></script>
  <script src="../js/home.js"></script>
</head>
<body>

  <!-- Navbar include (file must be in the same folder) -->
  <div w3-include-html="navbar.html"></div>

  <!-- Page Content -->
  <section class="section">
    <div class="section-header">
      <h2>Kanban Overview</h2>
      <a href="kanbanPage.html" class="view-button">
        <i class="bi bi-kanban"></i> View
      </a>
    </div>
    <div id="kanban"></div>
  </section>

  <section class="section">
    <div class="section-header">
      <h2>Gantt Overview</h2>
      <a href="ganttPage.html" class="view-button">
        <i class="fa-solid fa-chart-gantt"></i> View
      </a>
    </div>
    <div id="gantt"></div>
  </section>

  <section class="section">
    <h2>Most Recent Projects</h2>
    <div id="recent-projects-container"></div>
  </section>

  <!-- Execute navbar include and bind logout -->
  <script>
    w3IncludeHTML(function () {
      const logoutBtn = document.querySelector(".logout-btn");
      if (logoutBtn) {
        logoutBtn.addEventListener("click", () => {
          document.cookie = "auth=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
          window.location.href = "../views/login.html";
        });
      }
    });
  </script>

</body>
</html>