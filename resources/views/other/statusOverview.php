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
  <title>Status Overview - Texas Gears</title>

  <!-- Styles -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jkanban@1.3.1/dist/jkanban.min.css">
  <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/24.2.6/css/dx-gantt.min.css">
  <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/24.2.6/css/dx.light.css">
  <link rel="stylesheet" href="../../css/home.css">
  <link rel="stylesheet" href="../../css/kanban.css">
</head>

<body>
  <!-- Navbar -->
  <?php 
  require_once $_SERVER['DOCUMENT_ROOT'] . '/SysDevProject/config/config.php';
  require BASE_PATH . '/resources/components/navbar.php';
  ?>

  <!-- Kanban Section -->
  <section class="section kanban-header">
    <div class="kanban-header-content">
      <h2 class="kanban-title" style="color: #F68A30;">Kanban Overview</h2>
      <a href="kanbanPage.html" class="view-button">
        <i class="fa-solid fa-table-columns"></i> View Kanban
      </a>
    </div>
    <div class="kanban-inline-filter">
      <input type="text" id="taskFilter" class="kanban-filter" placeholder="Filter tasks" />
    </div>
    <div id="kanban"></div>
  </section>

  <!-- Gantt Section -->
  <section class="section">
    <div class="section-header">
      <h2>Gantt Overview</h2>
      <a href="#kanban" class="view-button">
        <i class="fa-solid fa-table-columns"></i> View
      </a>
    </div>
    <div id="gantt"></div>
  </section>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jkanban@1.3.1/dist/jkanban.min.js"></script>
  <script src="https://cdn3.devexpress.com/jslib/24.2.6/js/dx-gantt.min.js"></script>
  <script src="https://cdn3.devexpress.com/jslib/24.2.6/js/dx.all.js"></script>
  <script src="../../js/home.js"></script>
</body>
</html>
