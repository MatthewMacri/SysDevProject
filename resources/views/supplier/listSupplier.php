<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>All Suppliers</title>

  <!-- Link to shared CSS styling -->
  <link rel="stylesheet" href="../../css/home.css">
</head>

<body>

  <!-- Include the reusable navigation bar -->
  <?php 
    require_once $_SERVER['DOCUMENT_ROOT'] . '/SysDevProject/config/config.php';
    require BASE_PATH . '/resources/components/navbar.php';
  ?>

  <!-- Main content section -->
  <section class="section">
    <h2>All Suppliers</h2>

    <!-- Button/link to create a new supplier -->
    <a class="view-button" href="?controller=supplier&action=createForm">Create New Supplier</a>

    <!-- Loop through all suppliers and display them -->
    <ul>
      <?php foreach ($suppliers as $supplier): ?>
        <li class="project-card">
          <!-- Display supplier info -->
          <strong><?= htmlspecialchars($supplier['supplier_name']) ?></strong><br>
          Company: <?= htmlspecialchars($supplier['company_name']) ?><br>
          Email: <?= htmlspecialchars($supplier['supplier_email']) ?><br>
          Phone: <?= htmlspecialchars($supplier['supplier_phone_number']) ?><br>

          <!-- Links to edit or delete the supplier -->
          <a href="?controller=supplier&action=edit&id=<?= $supplier['supplier_id'] ?>">Edit</a> |
          <a href="?controller=supplier&action=delete&id=<?= $supplier['supplier_id'] ?>"
             onclick="return confirm('Are you sure you want to delete this supplier?')">Delete</a>
        </li>
      <?php endforeach; ?>
    </ul>
  </section>

  <!-- Script to support logout functionality -->
  <script src="https://www.w3schools.com/lib/w3data.js"></script>
  <script>
    // Wait for page to finish loading, then setup logout
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
              // Clear auth cookie and redirect to login page
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