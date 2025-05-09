<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Admin</title>
  <link rel="stylesheet" href="../../css/home.css">
  <link rel="stylesheet" href="../../css/form.css">
  <script src="https://www.w3schools.com/lib/w3data.js"></script>
</head>
<body>

<div w3-include-html="../../components/navbar.php"></div>

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

<!-- Full Logout Support -->
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