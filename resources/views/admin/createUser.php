<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create User</title>
  
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
    <h2>Create New User</h2>
    
    <!-- Form to input new user data -->
    <form method="POST">
      
      <!-- Input field for First Name -->
      <label for="firstName">First Name</label>
      <input type="text" id="firstName" name="firstName" required>
      
      <!-- Input field for Last Name -->
      <label for="lastName">Last Name</label>
      <input type="text" id="lastName" name="lastName" required>
      
      <!-- Input field for Username -->
      <label for="username">Username</label>
      <input type="text" id="username" name="username" required>
      
      <!-- Input field for Email -->
      <label for="email">Email</label>
      <input type="email" id="email" name="email" required>
      
      <!-- Input field for Password -->
      <label for="password">Password</label>
      <input type="password" id="password" name="password" required>
      
      <!-- Input field for Confirm Password -->
      <label for="confirmPassword">Confirm Password</label>
      <input type="password" id="confirmPassword" name="confirmPassword" required>
      
      <!-- Submit button to create the user -->
      <input type="submit" id="create-user-btn" value="Create User">
    </form>
  </div>

  <!-- Full Logout Support -->
  <script src="https://www.w3schools.com/lib/w3data.js"></script>
  <script>
    w3IncludeHTML(function () {
      const logoutBtn = document.querySelector(".logout-btn");
      
      if (logoutBtn) {
        logoutBtn.addEventListener("click", () => {
          // Send logout request to the server
          fetch("/SysDevProject/logout.php", {
            method: "POST",
            credentials: "include"
          })
          .then(res => res.json())
          .then(data => {
            if (data.success) {
              // Clear session and redirect to login page
              document.cookie = "auth=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
              window.location.href = "/SysDevProject/resources/views/login.html";
            } else {
              alert("Logout failed");
            }
          })
          .catch(err => {
            console.error("Logout error:", err);
            alert("Logout request failed.");
          });
        });
      }
    });
  </script>

</body>
</html>