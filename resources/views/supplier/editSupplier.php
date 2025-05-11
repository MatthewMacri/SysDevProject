<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Supplier</title>
  <link rel="stylesheet" href="../../css/home.css">
  <link rel="stylesheet" href="../../css/form.css">
</head>
<body>

<!-- Navbar -->
<?php 
  require_once $_SERVER['DOCUMENT_ROOT'] . '/SysDevProject/config/config.php';
  require BASE_PATH . '/resources/components/navbar.php';
  ?>

<section class="section">
  <h2>Edit Supplier</h2>
  <form method="post" action="?controller=supplier&action=update&id=<?= $supplier['supplier_id'] ?>">
      <input type="text" name="supplier_name" value="<?= htmlspecialchars($supplier['supplier_name']) ?>" required><br>
      <input type="text" name="company_name" value="<?= htmlspecialchars($supplier['company_name']) ?>" required><br>
      <input type="email" name="supplier_email" value="<?= htmlspecialchars($supplier['supplier_email']) ?>" required><br>
      <input type="text" name="supplier_phone_number" value="<?= htmlspecialchars($supplier['supplier_phone_number']) ?>" required><br>
      <button type="submit">Update Supplier</button>
  </form>
</section>

<!-- Full Logout Script -->
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