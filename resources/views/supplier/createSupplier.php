<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create New Supplier</title>
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
  <h2>Create New Supplier</h2>
  <form method="post" action="?controller=supplier&action=store">
      <input type="text" name="supplier_name" placeholder="Supplier Name" required><br>
      <input type="text" name="company_name" placeholder="Company Name" required><br>
      <input type="email" name="supplier_email" placeholder="Email" required><br>
      <input type="text" name="supplier_phone_number" placeholder="Phone Number" required><br>
      <button type="submit">Add Supplier</button>
  </form>
</section>

<!-- Full Logout Support -->
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