<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?php echo _('History of Project'); ?></title>

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="/SysDevProject/public/images/logo/favicon-gear.png" />

  <!-- Stylesheets -->
  <link rel="stylesheet" href="../../css/history.css">
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
    <!-- Search section for project history -->
    <div class="search-section">
      <label for="serialInput" style="text-align: start;">
        <?php echo _('Project Serial Number'); ?><span class="required" style="margin-left: 4px;">*</span>
      </label>
      <input type="text" id="serialInput" />
      <button class="orange-button" id="searchBtn"><?php echo _('History of Project'); ?></button>
    </div>

    <!-- Field validation note -->
    <p class="required-note"><span class="required">*</span> <?php echo _('Required field'); ?></p>

    <!-- Result container dynamically filled by JavaScript -->
    <div class="history-box" id="historyResults"></div>
  </main>

  <!-- JavaScript for history search functionality -->
  <script src="../../js/history.js"></script>

</body>
</html>