<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin List</title>
  <link rel="stylesheet" href="resources/css/listAdmins.css">
  <script src="https://www.w3schools.com/lib/w3data.js"></script>
</head>

<body>
  <!-- Load Navbar -->
  <div w3-include-html="resources/components/navbar.php"></div>

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