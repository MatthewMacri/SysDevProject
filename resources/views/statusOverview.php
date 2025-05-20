<?php
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';
$app = require_once dirname(__DIR__, 2) . '/bootstrap/app.php';

require_once app_path('Http/Controllers/core/databaseController.php');

use App\Http\Controllers\core\DatabaseController;

// Connect to SQLite
$databaseInstance = DatabaseController::getInstance();
$db = $databaseInstance->getConnection();
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Fetch projects from PROJECT table
$query = $db->query("SELECT project_id, project_name, start_date, end_date FROM PROJECT");

$tasks = [];
while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
  $tasks[] = [
    'id' => (int)$row['project_id'],
    'title' => $row['project_name'],
    'start' => date('c', strtotime($row['start_date'])),
    'end' => date('c', strtotime($row['end_date'])),
    'parentId' => 0 // Flat hierarchy
  ];
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

  <!-- Local CSS -->
  <link rel="stylesheet" href="/SysDevProject/resources/css/home.css">
  <link rel="stylesheet" href="/SysDevProject/resources/css/kanban.css">
  <style>
    #gantt {
      height: 500px;
      margin-top: 20px;
    }
  </style>
</head>

<body>

  <!-- Navbar -->
  <?php
  require_once dirname(__DIR__, 2) . '/vendor/autoload.php';
  $app = require_once dirname(__DIR__,2) . '/bootstrap/app.php';

  require resource_path('components/navbar.php');
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
      <input type="text" id="taskFilter" class="kanban-filter" placeholder="Filter tasks">
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

  <!-- External JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jkanban@1.3.1/dist/jkanban.min.js"></script>
  <script src="https://cdn3.devexpress.com/jslib/24.2.6/js/dx.all.js"></script>
  <script src="https://cdn3.devexpress.com/jslib/24.2.6/js/dx-gantt.min.js"></script>

  <!-- Local JS -->
  <script src="/SysDevProject/resources/js/home.js"></script>

  <!-- Gantt Initialization -->
  <script>
    const tasks = <?php echo json_encode($tasks, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>;

    $(document).ready(function () {
      $("#gantt").dxGantt({
        tasks: {
          dataSource: tasks,
          keyExpr: "id",
          parentIdExpr: "parentId",
          startExpr: "start",
          endExpr: "end",
          titleExpr: "title"
        },
        height: 500
      });
    });
  </script>

</body>
</html>