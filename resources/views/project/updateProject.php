<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?php echo _('Project Details'); ?></title>

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="/SysDevProject/public/images/logo/favicon-gear.png" />
  <link rel="stylesheet" href="../../css/updateProject.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

<?php
if (!function_exists('resource_path')) {
    require_once dirname(__DIR__, 3) . '/vendor/autoload.php';
    require_once dirname(__DIR__, 3) . '/bootstrap/app.php';
    require_once dirname(__DIR__, 3) . '/app/Http/Controllers/core/DatabaseController.php';
}

use App\Http\Controllers\core\DatabaseController;
require resource_path('components/navbar.php');

$db = DatabaseController::getInstance()->getConnection();

// updating project
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $serial = $_POST['serial'] ?? null;

    if (!$serial) die('No serial number provided.');

    $stmt = $db->prepare("
        UPDATE Project
        SET 
            project_name = :name,
            project_description = :description,
            start_date = :startDate,
            end_date = :endDate,
            buffer_days = :bufferDays,
            status = :status
        WHERE serial_number = :serial
    ");

    $stmt->execute([
        ':name' => $_POST['projectTitle'],
        ':description' => $_POST['projectDescription'],
        ':startDate' => $_POST['supplierDate'],
        ':endDate' => $_POST['clientDate'],
        ':bufferDays' => $_POST['bufferDays'],
        ':status' => $_POST['projectStatus'],
        ':serial' => $serial
    ]);
}

  // fetching project
  $serial = $_GET['serial'] ?? $_POST['serial'] ?? null;
  if (!$serial) die('No serial number provided.');

  $stmt = $db->prepare("SELECT * FROM Project WHERE serial_number = :serial");
  $stmt->execute([':serial' => $serial]);
  $project = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$project) die("Project not found.");
  ?>

  <main>
    <form class="project-form" method="POST" action="updateProject.php">
      <input type="hidden" name="serial" value="<?= htmlspecialchars($project['serial_number']) ?>">

      <div class="project-header">
        <div>
          <input id="projectTitle" name="projectTitle" class="input-title" placeholder="Project Title"
                value="<?= htmlspecialchars($project['project_name'] ?? '') ?>" />
          <p class="project-id" id="projectSerial"><?php echo _('Project Serial #'); ?>: <?= htmlspecialchars($project['serial_number'] ?? '') ?></p>
        </div>
        <input id="projectStatus" name="projectStatus" class="input-status" placeholder="Status"
              value="<?= htmlspecialchars($project['status'] ?? '') ?>" />
      </div>
      
      <!-- Project Description -->
      <h4><?php echo _('Project Description'); ?>:</h4>
      <div class="project-description">
        <textarea id="projectDescription" name="projectDescription" class="input-textarea"><?= htmlspecialchars($project['project_description'] ?? '') ?></textarea>
      </div>

      <div class="gray-box">
        <label for="clientDetails"><?php echo _('Client Details'); ?>:</label>
        <textarea id="clientDetails" name="clientDetails" class="input-textarea"><?= htmlspecialchars($project['client_details'] ?? '') ?></textarea>

        <label for="supplierInfo"><?php echo _('Supplier Info'); ?>:</label>
        <textarea id="supplierInfo" name="supplierInfo" class="input-textarea"><?= htmlspecialchars($project['supplier_info'] ?? '') ?></textarea>

        <label for="supplierDate"><?php echo _('Supplier Date'); ?>:</label>
        <input type="date" id="supplierDate" name="supplierDate" class="input-date"
              value="<?= htmlspecialchars($project['start_date'] ?? '') ?>" />

        <label for="clientDate"><?php echo _('Client Date'); ?>:</label>
        <input type="date" id="clientDate" name="clientDate" class="input-date"
              value="<?= htmlspecialchars($project['end_date'] ?? '') ?>" />

        <label for="bufferDays"><?php echo _('Buffer Days (Slack Time)'); ?>:</label>
        <input type="number" id="bufferDays" name="bufferDays" class="input-number"
              value="<?= htmlspecialchars($project['buffer_days'] ?? '') ?>" />
      </div>

      <div class="media-section">
        <button type="button" class="media-button">
          <?php echo _('Project Media'); ?> <i class="fas fa-image"></i>
        </button>
        <button type="button" class="media-button">
          <?php echo _('KanBan Board'); ?> <i class="fas fa-table-columns"></i>
        </button>
        <button type="button" class="media-button">
          <?php echo _('Gantt Chart'); ?> <i class="fas fa-chart-bar"></i>
        </button>
      </div>

      <div class="form-actions">
        <a href="/SysDevProject/resources/views/project/searchProject.php" class="form-button cancel-button"><?php echo _('Cancel'); ?></a>
        <button type="submit" class="form-button confirm-Confirm"><?php echo _('Confirm'); ?></button>
      </div>
    </form>
  </main>

  <div id="confirmationPopup" class="popup-overlay">
    <div class="popup-box">
      <p><?php echo _('You are updating a project. Please make sure the information provided is correct.'); ?></p>
      <div class="popup-buttons">
        <button id="cancelPopup" class="orange-btn small"><?php echo _('Cancel'); ?></button>
        <button id="confirmPopup" class="orange-btn small"><?php echo _('Confirm'); ?></button>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="../../js/updateProject.js"></script>
  
</body>
</html>
