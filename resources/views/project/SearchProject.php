<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo _('Project Search'); ?></title>

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="/SysDevProject/public/images/logo/favicon-gear.png" />

  <!-- Stylesheets -->
  <link rel="stylesheet" href="../../css/searchProject.css">
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

    <!-- Project Search Form -->
    <div class="Search-container" style="margin-top: 40px;">
      <form class="project-search-box" method="GET"
            action="/SysDevProject/project/search">

        <!-- Serial Number -->
        <div class="form-group">
          <label for="serialNumber"><?php echo _('Serial Number'); ?></label>
          <input type="text" id="serialNumber" name="serialNumber" style="height: 25px;">
        </div>

        <!-- Project Title -->
        <div class="form-group">
          <label for="projectTitle"><?php echo _('Project Title'); ?></label>
          <input type="text" id="projectTitle" name="projectTitle" style="height: 25px;">
        </div>

        <!-- Project Status -->
        <div class="form-group">
          <label for="projectStatus"><?php echo _('Project Status'); ?></label>
          <input type="text" id="projectStatus" name="projectStatus" style="height: 25px;">
        </div>

        <!-- Supplier Name -->
        <div class="form-group">
          <label for="supplierName"><?php echo _('Supplier Name'); ?></label>
          <input type="text" id="supplierName" name="supplierName" style="height: 25px;">
        </div>

        <!-- Client Name -->
        <div class="form-group">
          <label for="clientName"><?php echo _('Client Name'); ?></label>
          <input type="text" id="clientName" name="clientName" style="height: 25px;">
        </div>

        <!-- Submit Button -->
        <div class="form-group button-wrapper">
          <button type="submit" class="orange-button"><?php echo _('Search Project'); ?></button>
        </div>
      </form>
    </div>

    <!-- Search Results -->
    <div id="results">
      <?php if (!empty($projects)): ?>
        <?php foreach ($projects as $project): ?>
          <div class="result-card">
            <div class="result-header">
              <div>
                <strong>#<?= htmlspecialchars($project['serial_number']) ?></strong><br>
                <span><?= htmlspecialchars($project['project_name']) ?></span><br>
                <small><?= htmlspecialchars($project['project_description']) ?></small><br>
                <small><?php echo _('Client'); ?>: <?= htmlspecialchars($project['client_name']) ?></small><br>
                <small><?php echo _('Supplier'); ?>: <?= htmlspecialchars($project['supplier_name']) ?></small>
              </div>
              <div class="project-status"><?= htmlspecialchars($project['status']) ?></div>
            </div>

            <!-- Action Buttons -->
            <div class="button-row">
              <div class="left-buttons">
                <button class="action-button"><?php echo _('Update'); ?></button>
                <button class="action-button"><?php echo _('Delete'); ?></button>
                <button class="action-button"><?php echo _('History'); ?></button>
              </div>
              <div class="right-button">
                <button class="action-button"><?php echo _('Export as PDF'); ?></button>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p style="text-align: center;"><?php echo _('No projects found.'); ?></p>
      <?php endif; ?>
    </div>
  </main>

  <!-- Page-specific JavaScript -->
  <script src="../../js/searchProject.js"></script>

</body>
</html>