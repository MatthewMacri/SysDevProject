<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo _('All Suppliers'); ?></title>

  <!-- Link to shared CSS styling -->
  <link rel="stylesheet" href="../../css/home.css">
</head>

<body>

  <!-- Include the reusable navigation bar -->
  <?php
  require_once dirname(__DIR__, 3) . '/vendor/autoload.php';
  $app = require_once dirname(__DIR__,3) . '/bootstrap/app.php';

  require resource_path('components/navbar.php');
  ?>

  <!-- Main content section -->
  <section class="section">
    <h2><?php echo _('All Suppliers'); ?></h2>

    <!-- Button/link to create a new supplier -->
    <a class="view-button" href="/SysDevProject/supplier/createForm"><?php echo _('Create New Supplier'); ?></a>

    <!-- Loop through all suppliers and display them -->
    <ul>
      <?php foreach ($suppliers as $supplier): ?>
        <li class="project-card">
          <!-- Display supplier info -->
          <strong><?= htmlspecialchars($supplier['supplier_name']) ?></strong><br>
          <?php echo _('Company'); ?>: <?= htmlspecialchars($supplier['company_name']) ?><br>
          <?php echo _('Email'); ?>: <?= htmlspecialchars($supplier['supplier_email']) ?><br>
          <?php echo _('Phone'); ?>: <?= htmlspecialchars($supplier['supplier_phone_number']) ?><br>

          <!-- Links to edit or delete the supplier -->
          <a href="/SysDevProject/supplier/edit/<?= $supplier['supplier_id'] ?>"><?php echo _('Edit'); ?></a> |
          <a href="/SysDevProject/supplier/delete/<?= $supplier['supplier_id'] ?>"
             onclick="return confirm('Are you sure you want to delete this supplier?')"><?php echo _('Delete'); ?></a>
        </li>
      <?php endforeach; ?>
    </ul>
  </section>
  
</body>
</html>