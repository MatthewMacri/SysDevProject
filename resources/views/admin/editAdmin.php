<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo _('Edit Admin'); ?></title>
  
  <!-- Link to stylesheets for the page -->
  <link rel="stylesheet" href="../../css/home.css">
  <link rel="stylesheet" href="../../css/form.css">
</head>
<body>

<?php
  require_once dirname(__DIR__, 3) . '/vendor/autoload.php';
  $app = require_once dirname(__DIR__,3) . '/bootstrap/app.php';

  require resource_path('components/navbar.php');
  ?>

<!-- Main Section for Editing Admin -->
<section class="section">
  <h2><?php echo _('Edit Admin'); ?></h2>
  
  <!-- Form to update admin details -->
 <form method="post" action="/sysdevproject/admin/update/<?= $admin['admin_id'] ?>">
      <!-- Admin Name -->
      <input type="text" name="admin_name" value="<?= htmlspecialchars($admin['admin_name']) ?>" required><br>

      <!-- First Name -->
      <input type="text" name="first_name" value="<?= htmlspecialchars($admin['first_name']) ?>" required><br>

      <!-- Last Name -->
      <input type="text" name="last_name" value="<?= htmlspecialchars($admin['last_name']) ?>" required><br>

      <!-- Email Address -->
      <input type="email" name="email" value="<?= htmlspecialchars($admin['email']) ?>" required><br>

      <!-- New Password (Optional) -->
      <input type="password" name="password" placeholder="<?php echo _('New Password'); ?>"><br>

      <!-- Submit Button to update the admin -->
      <button type="submit"><?php echo _('Update Admin'); ?></button>
  </form>
</section>

</body>
</html>