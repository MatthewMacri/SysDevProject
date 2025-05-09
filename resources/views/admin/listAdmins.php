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
  <div w3-include-html="resources/views/navbar.html"></div>

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

  <!-- Scripts -->
  <script src="https://www.w3schools.com/lib/w3data.js"></script>
  <script>
    w3IncludeHTML();
  </script>
</body>

</html>