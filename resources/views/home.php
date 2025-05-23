<?php
require_once dirname(__DIR__, 1) . '/services/i18n.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
  if (!isset($_SESSION['role'])) {
        header("Location: ./login/loginview.php");
        exit;
  } 

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title><?php echo _('Texas Gears Dashboard'); ?></title>

  <!-- External Styles for icons, kanban, and gantt components -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/24.2.6/css/dx.light.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jkanban@1.3.1/dist/jkanban.min.css">
  <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/24.2.6/css/dx-gantt.min.css">

  <!-- Internal CSS for layout -->
  <link rel="stylesheet" href="../css/home.css">
  <link rel="stylesheet" href="../css/kanban.css">

  <!-- External Libraries -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn3.devexpress.com/jslib/24.2.6/js/dx-gantt.min.js"></script>
  <script src="https://cdn3.devexpress.com/jslib/24.2.6/js/dx.all.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jkanban@1.3.1/dist/jkanban.min.js"></script>

  <!-- Local JavaScript logic for Kanban, Gantt, and Recent Projects -->
  <!-- Project Scripts -->
  <script src="/SysDevProject/resources/js/home.js"></script>
</head>
<body>

  <!-- Include the top navigation bar -->
  <?php
  require_once dirname(__DIR__, 2) . '/vendor/autoload.php';
  $app = require_once dirname(__DIR__,2) . '/bootstrap/app.php';

  require resource_path('components/navbar.php');
  ?>

  <!-- Kanban Board Section -->
  <section class="section kanban-header">
    <div class="kanban-header-content">
      <h2 class="kanban-title" style="color: #F68A30;"><?php echo _('Kanban Overview'); ?></h2>
      <!-- Link to full Kanban board page -->
      <a href="kanbanPage.html" class="view-button">
        <i class="fa-solid fa-table-columns"></i> <?php echo _('View Kanban'); ?>
      </a>
    </div>
    <!-- Filter input to search tasks by text -->
    <div class="kanban-inline-filter">
      <input type="text" id="taskFilter" class="kanban-filter" placeholder="Filter tasks">
    </div>
    <!-- Div where Kanban board will be generated -->
    <div id="kanban"></div>
  </section>

  <!-- Gantt Chart Section -->
  <section class="section">
    <div class="section-header">
      <h2><?php echo _('Gantt Overview'); ?></h2>
      <a href="#kanban" class="view-button">
        <i class="fa-solid fa-table-columns"></i> <?php echo _('View Gantt'); ?>
      </a>
    </div>
    <!-- Div where Gantt chart will load -->
    <div id="gantt"></div>
  </section>

  <!-- Recent Projects Section -->
  <section class="section">
    <h2><?php echo _('Most Recent Projects'); ?></h2>
    <!-- Cards will be injected dynamically into this div -->
    <div id="recent-projects-container"></div>
  </section>

</body>
</html>
