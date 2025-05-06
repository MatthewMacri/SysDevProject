<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Admin</title>
  <link rel="stylesheet" href="../../../css/home.css">
  <link rel="stylesheet" href="../../../css/navbar.css">
  <link rel="stylesheet" href="../../../css/form.css">
  <script src="https://www.w3schools.com/lib/w3data.js"></script>
</head>
<body>

<div w3-include-html="../../../views/navbar.html"></div>

<section class="section">
  <h2>Edit Admin</h2>
  <form method="post" action="?controller=admin&action=update&id=<?= $admin['admin_id'] ?>">
      <input type="text" name="admin_name" value="<?= htmlspecialchars($admin['admin_name']) ?>" required><br>
      <input type="text" name="first_name" value="<?= htmlspecialchars($admin['first_name']) ?>" required><br>
      <input type="text" name="last_name" value="<?= htmlspecialchars($admin['last_name']) ?>" required><br>
      <input type="email" name="email" value="<?= htmlspecialchars($admin['email']) ?>" required><br>
      <input type="password" name="password" placeholder="New Password"><br>
      <button type="submit">Update Admin</button>
  </form>
</section>

<script>w3IncludeHTML();</script>
</body>
</html>