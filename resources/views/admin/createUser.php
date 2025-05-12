<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create User</title>
  <link rel="icon" type="image/png" href="/SysDevProject/public/images/logo/favicon-gear.png" />
  <link rel="stylesheet" href="../../css/createUser.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

  <!-- Include the shared navbar -->
  <?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/SysDevProject/config/config.php';
require_once BASE_PATH . '/app/Http/Controllers/core/databaseController.php';

use Controllers\DatabaseController;


// DEBUG: Run init() once to ensure tables exist
$db = DatabaseController::getInstance();
$db->init(); // ⬅️ remove this after confirming Users table exists

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = DatabaseController::getInstance();
    $pdo = $db->getConnection();

    $first = $_POST['firstName'];
    $last = $_POST['lastName'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm = $_POST['confirmPassword'];

    if ($password !== $confirm) {
        echo "<p style='color:red; text-align:center;'>❌ Passwords do not match.</p>";
    } else {
        $hashed = password_hash($password, PASSWORD_BCRYPT);

        try {
            $stmt = $pdo->prepare("INSERT INTO Users (user_name, first_name, last_name, email, password, is_deactivated) VALUES (?, ?, ?, ?, ?, 0)");
            $stmt->execute([$username, $first, $last, $email, $hashed]);

            echo "<p style='color:green; text-align:center;'>✅ User created successfully.</p>";
        } catch (PDOException $e) {
            echo "<p style='color:red; text-align:center;'>❌ Failed: " . $e->getMessage() . "</p>";
        }
    }
}
?>


  <div class="form-container">
    <h2>Create New User</h2>
    <form method="POST">
      <label for="firstName">First Name</label>
      <input type="text" id="firstName" name="firstName" required>

      <label for="lastName">Last Name</label>
      <input type="text" id="lastName" name="lastName" required>

      <label for="username">Username</label>
      <input type="text" id="username" name="username" required>

      <label for="email">Email</label>
      <input type="email" id="email" name="email" required>

      <label for="password">Password</label>
      <input type="password" id="password" name="password" required>

      <label for="confirmPassword">Confirm Password</label>
      <input type="password" id="confirmPassword" name="confirmPassword" required>

      <input type="submit" id="create-user-btn" value="Create User">
    </form>
  </div>

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