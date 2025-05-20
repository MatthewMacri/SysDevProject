<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo _('Create New Supplier'); ?></title>

  <!-- Shared styles for layout and forms -->
  <link rel="stylesheet" href="../../css/home.css">
  <link rel="stylesheet" href="../../css/form.css">
</head>

<body>

  <!-- Include shared navigation bar -->
  <?php
  require_once dirname(__DIR__, 3) . '/vendor/autoload.php';
  $app = require_once dirname(__DIR__,3) . '/bootstrap/app.php';

  require resource_path('components/navbar.php');
  ?>

  <!-- Supplier Creation Form -->
  <section class="section">
    <h2><?php echo _('Create New Supplier'); ?></h2>

    <!-- Form to submit supplier data to the MVC controller -->
    <form method="post" action="/SysDevProject/supplier/store">

      <!-- Supplier Name -->
      <input type="text" name="supplier_name" placeholder="<?php echo _('Supplier Name'); ?>" required><br>

      <!-- Company Name -->
      <input type="text" name="company_name" placeholder="<?php echo _('Company Name'); ?>" required><br>

      <!-- Email -->
      <input type="email" name="supplier_email" placeholder="<?php echo _('Email'); ?>" required><br>

      <!-- Phone Number -->
      <input type="text" name="supplier_phone_number" placeholder="<?php echo _('Phone Number'); ?>" required><br>

      <!-- Submit Button -->
      <button type="submit"><?php echo _('Add Supplier'); ?></button>
    </form>
  </section>

  <!-- Logout Script (Fetch API) -->
  <script src="https://www.w3schools.com/lib/w3data.js"></script>
  <script>
    w3IncludeHTML(function () {
      const logoutBtn = document.querySelector(".logout-btn");
      if (logoutBtn) {
        logoutBtn.addEventListener("click", () => {
          fetch("/SysDevProject/logout.php", {
            method: "POST",
            credentials: "include"
          })
          .then(res => res.json())
          .then(data => {
            if (data.success) {
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