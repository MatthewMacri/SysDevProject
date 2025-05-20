<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo _('Admin List'); ?></title>
  
  <!-- Link to the stylesheet for the Admin List page -->
  <link rel="stylesheet" href="../../css/listAdmins.css">
</head>

<body>
  <!-- Load shared Navbar -->
  <?php
  require_once dirname(__DIR__, 3) . '/vendor/autoload.php';
  $app = require_once dirname(__DIR__,3) . '/bootstrap/app.php';

  require resource_path('components/navbar.php');
  ?>

  <!-- Main Content Section for Admin List -->
  <section class="section">
    <h2><?php echo _('Admin List'); ?></h2>
    
    <!-- Button to add a new admin -->
    <a class="view-button" href="/SysDevProject/admin/create"><?php echo _('Add Admin'); ?></a>
    
    <!-- List of Admins -->
    <ul class="admin-list">
      <?php foreach ($admins as $admin): ?>
        <li class="admin-card">
          <!-- Display each admin's name and email -->
          <strong><?= htmlspecialchars($admin['admin_name']) ?></strong><br>
          <?= htmlspecialchars($admin['email']) ?>
        </li>
      <?php endforeach; ?>
    </ul>
  </section>

</body>
</html>