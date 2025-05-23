<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo _('Create Admin'); ?></title>

  <!-- CSS styles for the form -->
  <link rel="stylesheet" href="../../css/adminCreate.css" />
  <!-- Font Awesome for icons (if needed later) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>

  <!-- Load the shared top navigation bar -->
  <?php
  require_once dirname(__DIR__, 3) . '/vendor/autoload.php';
  $app = require_once dirname(__DIR__,3) . '/bootstrap/app.php';

  require resource_path('components/navbar.php');
  ?>

  <!-- Admin creation form -->
  <h2><?php echo _('Create New Admin'); ?></h2>
  <form method="post" action="/SysDevProject/admin/store">
    <!-- Admin account fields -->
    <input type="text" name="admin_name" placeholder="<?php echo _('Admin Username'); ?>" required><br>
    <input type="text" name="first_name" placeholder="<?php echo _('First Name'); ?>" required><br>
    <input type="text" name="last_name" placeholder="<?php echo _('Last Name'); ?>" required><br>
    <input type="email" name="email" placeholder="<?php echo _('Email'); ?>" required><br>
    <input type="password" name="password" placeholder="<?php echo _('Password'); ?>" required><br>

    <!-- Submit button to create the admin -->
    <button type="submit"><?php echo _('Create Admin'); ?></button>
  </form>

</body>
</html>