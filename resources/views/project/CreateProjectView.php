<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Project</title>

  <link rel="icon" type="image/png" href="/SysDevProject/public/images/logo/favicon-gear.png" />
  <link rel="stylesheet" href="/SysDevProject/resources/css/createProject.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

  <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/SysDevProject/resources/components/navbar.php'; ?>

  <main>
    <main>
  <!-- Project Creation Form -->
  <form class="project-form">
    <div class="form-group">
      <label>Project Name<span class="required">*</span></label>
      <input type="text" name="project-name" required />
    </div>

    <div class="form-group">
      <label>Project Description</label>
      <textarea name="project-description" rows="4"></textarea>
    </div>

    <button type="submit" class="form-button create-button">Create Project</button>
  </form>

  <!-- Add Supplier Button -->
  <div class="bottom-buttons">
    <button id="supplierButton" class="form-button">Add Supplier</button>
  </div>

  <!-- Container for Supplier Sections -->
  <div id="supplier-sections"></div>

  <!-- Confirmation Popup Modal -->
  <div id="confirmationPopup" class="popup-overlay" style="display: none;">
    <div class="popup-box">
      <p>Are you sure you want to create this project?</p>
      <div class="popup-buttons">
        <button id="cancelPopup" class="orange-btn small">Cancel</button>
        <button id="confirmPopup" class="orange-btn small">Confirm</button>
      </div>
    </div>
  </div>
  </main>

  <!-- ✅ JS Scripts -->
  <script src="/SysDevProject/resources/js/createProject.js"></script>

  <script>
    // ✅ JS logout logic
    document.addEventListener("DOMContentLoaded", function () {
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