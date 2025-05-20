<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo _('Create User'); ?></title>
  
  <!-- Favicon for the page -->
  <link rel="icon" type="image/png" href="/SysDevProject/public/images/logo/favicon-gear.png" />
  
  <!-- External Stylesheets -->
  <link rel="stylesheet" href="../../css/createUser.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

  <!-- Include the shared top navigation bar -->
  <?php
  require_once dirname(__DIR__, 3) . '/vendor/autoload.php';
  $app = require_once dirname(__DIR__,3) . '/bootstrap/app.php';

  require resource_path('components/navbar.php');
  ?>

  <!-- Form Section for Creating a New User -->
  <div class="form-container">
    <h2><?php echo _('Create New User'); ?></h2>
    
    <!-- Form to input new user data -->
    <form method="POST">
      
      <!-- Input field for First Name -->
      <label for="firstName"><?php echo _('First Name'); ?></label>
      <input type="text" id="firstName" name="firstName" required>
      
      <!-- Input field for Last Name -->
      <label for="lastName"><?php echo _('Last Name'); ?></label>
      <input type="text" id="lastName" name="lastName" required>
      
      <!-- Input field for Username -->
      <label for="username"><?php echo _('Username'); ?></label>
      <input type="text" id="username" name="username" required>
      
      <!-- Input field for Email -->
      <label for="email"><?php echo _('Email'); ?></label>
      <input type="email" id="email" name="email" required>
      
      <!-- Input field for Password -->
      <label for="password"><?php echo _('Password'); ?></label>
      <input type="password" id="password" name="password" required>
      
      <!-- Input field for Confirm Password -->
      <label for="confirmPassword"><?php echo _('Confirm Password'); ?></label>
      <input type="password" id="confirmPassword" name="confirmPassword" required>
      
      <!-- Submit button to create the user -->
      <input type="submit" id="create-user-btn" value="Create User">
    </form>
  </div>

</body>
</html>