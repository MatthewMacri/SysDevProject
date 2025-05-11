<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin List</title>
  <link rel="stylesheet" href="../../css/listAdmins.css">
</head>

<body>
  <!-- Load Navbar -->
  <?php 
  require_once $_SERVER['DOCUMENT_ROOT'] . '/SysDevProject/config/config.php';
  require BASE_PATH . '/resources/components/navbar.php';
  ?>

  <!-- Main Content -->
  <section class="section">
    <h2>Admin List</h2>
    <a class="view-button" href="?controller=admin&action=create">Add Admin</a>
    <ul class="admin-list">
      <?php foreach ($admins as $admin): ?>
        <li class="admin-card">
          <strong><?= htmlspecialchars($admin['admin_name']) ?></strong><br>
          <?= htmlspecialchars($admin['email']) ?>
        </li>
      <?php endforeach; ?>
    </ul>
  </section>

  <!-- Logout Support Script -->
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