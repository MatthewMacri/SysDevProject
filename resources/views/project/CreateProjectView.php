<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Create Project</title>

  <!-- Stylesheets -->
  <link rel="stylesheet" href="../../css/createProject.css">
  <link rel="stylesheet" href="../../css/navbar.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="icon" type="image/png" href="/SysDevProject/public/images/logo/favicon-gear.png" />
</head>

<body>
  <main>

    <!-- Include shared navbar -->
    <?php
      require_once $_SERVER['DOCUMENT_ROOT'] . '/SysDevProject/config/config.php';
      require BASE_PATH . '/resources/components/navbar.php';
    ?>

    <!-- Project creation form -->
    <form class="project-form" method="POST">
      
      <!-- Project information -->
      <div class="form-section">
        <div class="form-group">
          <label for="project-title">Project Title<span class="required">*</span></label>
          <input type="text" id="project-title" name="project-title" required>
        </div>

        <div class="form-group">
          <label for="project-serial-number">Project Serial Number<span class="required">*</span></label>
          <input type="text" id="project-serial-number" name="project-serial-number" required>
        </div>

        <div class="form-group">
          <label for="project-description">Project Description<span class="required">*</span></label>
          <textarea id="project-description" name="project-description" required></textarea>
        </div>
      </div>

      <!-- Start Date -->
      <div class="date-picker-container">
        <button type="button" onclick="document.getElementById('project-start-date').showPicker()">
          <div class="date-label">Project Start Date<span class="required">*</span></div>
          <i class="fas fa-calendar-alt calendar-icon"></i>
          <input type="date" id="project-start-date" name="project-start-date" class="hidden-date-input" required />
        </button>
      </div>

      <!-- End Date -->
      <div class="date-picker-container">
        <button type="button" onclick="document.getElementById('project-end-date').showPicker()">
          <div class="date-label">Project End Date<span class="required">*</span></div>
          <i class="fas fa-calendar-alt calendar-icon"></i>
          <input type="date" id="project-end-date" name="project-end-date" class="hidden-date-input" required />
        </button>
      </div>

      <!-- Client Details -->
      <div class="form-section client-details">
        <h2>Client Details</h2>
        <div class="form-group">
          <label for="client-name">Client Name<span class="required">*</span></label>
          <input type="text" id="client-name" name="client-name" required>
        </div>
        <div class="form-group">
          <label for="client-company">Company Name<span class="required">*</span></label>
          <input type="text" id="client-company" name="client-company" required>
        </div>
        <div class="form-group">
          <label for="client-email">Email<span class="required">*</span></label>
          <input type="email" id="client-email" name="client-email" required>
        </div>
        <div class="form-group">
          <label for="client-phone">Phone Number<span class="required">*</span></label>
          <input type="tel" id="client-phone" name="client-phone" required>
        </div>
      </div>

      <!-- Supplier Section -->
      <div id="supplier-sections">
        <div class="form-section supplier-details">
          <h2>Supplier Details</h2>
          <div class="form-group">
            <label for="supplier-name">Supplier Name<span class="required">*</span></label>
            <input type="text" id="supplier-name" name="supplier-name" required>
          </div>
          <div class="form-group">
            <label for="supplier-company">Company Name<span class="required">*</span></label>
            <input type="text" id="supplier-company" name="supplier-company" required>
          </div>
          <div class="form-group">
            <label for="supplier-email">Email<span class="required">*</span></label>
            <input type="email" id="supplier-email" name="supplier-email" required>
          </div>
          <div class="form-group">
            <label for="supplier-phone">Phone Number<span class="required">*</span></label>
            <input type="tel" id="supplier-phone" name="supplier-phone" required>
          </div>
        </div>
      </div>

      <!-- Add more suppliers -->
      <div class="suplier-button">
        <button type="button" id="supplierButton" class="add-supplier-btn">
          Add Another Supplier <i class="fas fa-plus"></i>
        </button>
      </div>

      <!-- Bottom Controls -->
      <div class="bottom-buttons">
        <!-- Supplier Date -->
        <div class="date-picker-container">
          <button type="button" onclick="document.getElementById('supplier-date').showPicker()">
            <div class="date-label">Supplier Date<span class="required">*</span></div>
            <i class="fas fa-calendar-alt calendar-icon"></i>
            <input type="date" id="supplier-date" name="supplier-date" class="hidden-date-input" />
          </button>
        </div>

        <!-- Add Media Button -->
        <div class="date-picker-container">
          <button type="button">
            <div class="date-label">Add Media</div>
            <i class="fas fa-plus media-icon"></i>
          </button>
        </div>
      </div>

      <!-- Required Field Note -->
      <p class="required-note"><span class="required">*</span> Required field</p>

      <!-- Action Buttons -->
      <div class="form-actions">
        <button type="button" class="form-button cancel-button">Cancel</button>
        <button type="submit" class="form-button create-button">Create</button>
      </div>
    </form>
  </main>

  <!-- Confirmation Popup Modal -->
  <div id="confirmationPopup" class="popup-overlay">
    <div class="popup-box">
      <p>You are creating a project. Please make sure the information provided is correct.</p>
      <div class="popup-buttons">
        <button id="cancelPopup" class="orange-btn small">Cancel</button>
        <button id="confirmPopup" class="orange-btn small">Confirm</button>
      </div>
    </div>
  </div>

  <!-- JavaScript for form logic -->
  <script src="../../js/createProject.js"></script>
</body>
</html>