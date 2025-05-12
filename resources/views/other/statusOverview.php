<?php
// Start session and restrict access to admins only
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

  <!-- External stylesheets -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jkanban@1.3.1/dist/jkanban.min.css">
  <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/24.2.6/css/dx-gantt.min.css">
  <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/24.2.6/css/dx.light.css">
  <link rel="stylesheet" href="../../css/home.css">
  <link rel="stylesheet" href="../../css/kanban.css">
</head>

<body>

  <!-- Include navbar -->
  <?php 
    require_once $_SERVER['DOCUMENT_ROOT'] . '/SysDevProject/config/config.php';
    require BASE_PATH . '/resources/components/navbar.php';
  ?>

  <!-- Kanban Board -->
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

  <!-- Gantt Chart -->
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

  <script>
    // Load Kanban Data
    fetch('../../api/get_kanban_data.php')
      .then(res => res.json())
      .then(data => {
        const board = new jKanban({
          element: '#kanban',
          boards: Object.entries(data).map(([status, tasks]) => ({
            id: status,
            title: status,
            item: tasks.map(task => ({
              id: task.id,
              title: task.title
            }))
          }))
        });

        // Optional: Add filter functionality
        document.getElementById("taskFilter").addEventListener("input", function () {
          const query = this.value.toLowerCase();
          document.querySelectorAll(".kanban-item").forEach(item => {
            const text = item.innerText.toLowerCase();
            item.style.display = text.includes(query) ? "block" : "none";
          });
        });
      });

    // Load Gantt Data
    fetch('../../api/get_gantt_data.php')
      .then(res => res.json())
      .then(data => {
        $("#gantt").dxGantt({
          tasks: {
            dataSource: data.tasks,
            keyExpr: "id",
            parentIdExpr: "parentId",
            startExpr: "start",
            endExpr: "end",
            titleExpr: "title"
          },
          dependencies: {
            dataSource: data.dependencies
          },
          height: 500
        });
      });
  </script>

</body>
</html>