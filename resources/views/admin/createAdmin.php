<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create Admin</title>

  <!-- CSS styles for the form -->
  <link rel="stylesheet" href="../../css/adminCreate.css" />
  <!-- Font Awesome for icons (if needed later) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>

  <!-- Load the shared top navigation bar -->
  <?php 
  require_once $_SERVER['DOCUMENT_ROOT'] . '/SysDevProject/config/config.php';
  require BASE_PATH . '/resources/components/navbar.php';
  ?>

  <!-- Admin creation form -->
  <h2>Create New Admin</h2>
  <form method="post" action="?controller=admin&action=store">
    <!-- Admin account fields -->
    <input type="text" name="admin_name" placeholder="Admin Username" required><br>
    <input type="text" name="first_name" placeholder="First Name" required><br>
    <input type="text" name="last_name" placeholder="Last Name" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>

    <!-- Submit button to create the admin -->
    <button type="submit">Create Admin</button>
  </form>

  <!-- Script to support logout functionality -->
  <script src="https://www.w3schools.com/lib/w3data.js"></script>
  <script>
    // When the page is ready, attach the logout function
    w3IncludeHTML(function () {
      const logoutBtn = document.querySelector(".logout-btn");
      if (logoutBtn) {
        logoutBtn.addEventListener("click", () => {
          // Send logout request to the server
          fetch("/SysDevProject/logout.php", {
            method: "POST",
            credentials: "include"
          })
          .then(res => res.json())
          .then(data => {
            if (data.success) {
              // Clear cookie and go back to login page
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