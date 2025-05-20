<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo _('Edit Supplier'); ?></title>

  <!-- Include basic styles for layout and form -->
  <link rel="stylesheet" href="../../css/home.css">
  <link rel="stylesheet" href="../../css/form.css">
</head>

<body>

  <!-- Load the shared navbar -->
  <?php
  require_once dirname(__DIR__, 3) . '/vendor/autoload.php';
  $app = require_once dirname(__DIR__,3) . '/bootstrap/app.php';

  require resource_path('components/navbar.php');
  ?>

  <!-- Main section for editing supplier -->
  <section class="section">
    <h2><?php echo _('Edit Supplier'); ?></h2>

    <!-- Form is pre-filled with the supplier's current information -->
    <form method="post" action=" /SysDevProject/supplier/update/<?= htmlspecialchars($supplier['supplier_id']) ?>">

      <!-- Supplier Name input -->
      <input type="text" name="supplier_name" value="<?= htmlspecialchars($supplier['supplier_name']) ?>" required><br>

      <!-- Company Name input -->
      <input type="text" name="company_name" value="<?= htmlspecialchars($supplier['company_name']) ?>" required><br>

      <!-- Email input -->
      <input type="email" name="supplier_email" value="<?= htmlspecialchars($supplier['supplier_email']) ?>" required><br>

      <!-- Phone Number input -->
      <input type="text" name="supplier_phone_number" value="<?= htmlspecialchars($supplier['supplier_phone_number']) ?>" required><br>

      <!-- Button to update supplier info -->
      <button type="submit"><?php echo _('Update Supplier'); ?></button>
    </form>
  </section>

  <!-- Support logout functionality -->
  <script src="https://www.w3schools.com/lib/w3data.js"></script>
  <script>
    // Set up logout button behavior
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
              // Clear the auth cookie and redirect to login
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