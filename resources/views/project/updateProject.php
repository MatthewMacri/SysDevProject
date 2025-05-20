<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?php echo _('Project Details'); ?></title>

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="/SysDevProject/public/images/logo/favicon-gear.png" />

  <!-- Stylesheets -->
  <link rel="stylesheet" href="../../css/updateProject.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

  <!-- Include shared navigation bar -->
  <?php
  require_once dirname(__DIR__, 3) . '/vendor/autoload.php';
  $app = require_once dirname(__DIR__,3) . '/bootstrap/app.php';

  require resource_path('components/navbar.php');
  ?>

  <main>
    <!-- Update Project Form -->
    <form class="project-form" method="POST" action="/SysDevProject/project/update">
      <!-- Optional: override method for RESTful routing -->
      <input type="hidden" name="_method" value="PUT">

      <!-- Project Header Fields -->
      <div class="project-header">
        <div>
          <input id="projectTitle" name="projectTitle" class="input-title" placeholder="Project Title" />
          <p class="project-id" id="projectSerial"><?php echo _('Project Serial #'); ?></p>
        </div>
        <input id="projectStatus" name="projectStatus" class="input-status" placeholder="Status" />
      </div>
      
      <!-- Project Description -->
      <h4><?php echo _('Project Description'); ?>:</h4>
      <div class="project-description">
        <textarea id="projectDescription" name="projectDescription" class="input-textarea"></textarea>
      </div>

      <!-- Project Metadata -->
      <div class="gray-box">
        <label for="clientDetails"><?php echo _('Client Details'); ?>:</label>
        <textarea id="clientDetails" name="clientDetails" class="input-textarea"></textarea>

        <label for="supplierInfo"><?php echo _('Supplier Info'); ?>:</label>
        <textarea id="supplierInfo" name="supplierInfo" class="input-textarea"></textarea>

        <label for="supplierDate"><?php echo _('Supplier Date'); ?>:</label>
        <input type="date" id="supplierDate" name="supplierDate" class="input-date" />

        <label for="clientDate"><?php echo _('Client Date'); ?>:</label>
        <input type="date" id="clientDate" name="clientDate" class="input-date" />

        <label for="bufferDays"><?php echo _('Buffer Days (Slack Time)'); ?>:</label>
        <input type="number" id="bufferDays" name="bufferDays" class="input-number" />
      </div>

      <!-- Media Action Buttons -->
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

      <!-- Form Actions -->
      <div class="form-actions">
        <button type="button" class="form-button cancel-button"><?php echo _('Cancel'); ?></button>
        <button type="submit" class="form-button confirm-Confirm"><?php echo _('Confirm'); ?></button>
      </div>
    </form>
  </main>

  <!-- Confirmation Popup -->
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