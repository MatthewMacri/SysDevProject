<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>History of Project</title>

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="/SysDevProject/public/images/logo/favicon-gear.png" />

  <!-- Stylesheets -->
  <link rel="stylesheet" href="../../css/history.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
  <!-- Include shared navigation bar -->
  <?php 
    require_once $_SERVER['DOCUMENT_ROOT'] . '/SysDevProject/config/config.php';
    require BASE_PATH . '/resources/components/navbar.php';
  ?>

  <main>
    <!-- Search section for project history -->
    <div class="search-section">
      <label for="serialInput" style="text-align: start;">
        Project Serial Number<span class="required" style="margin-left: 4px;">*</span>
      </label>
      <input type="text" id="serialInput" />
      <button class="orange-button" id="searchBtn">History of Project</button>
    </div>

    <!-- Field validation note -->
    <p class="required-note"><span class="required">*</span> Required field</p>

    <!-- Result container dynamically filled by JavaScript -->
    <div class="history-box" id="historyResults"></div>
  </main>

  <!-- JavaScript for history search functionality -->
  <script src="../../js/history.js"></script>

  <!-- Logout logic using Fetch API -->
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