<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Project</title>
  <link rel="stylesheet" href="../../css/createProject.css">
  <link rel="stylesheet" href="../../css/navbar.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="icon" type="image/png" href="/SysDevProject/public/images/logo/favicon-gear.png" />
</head>

<body>
  <main>

    <?php

    use Controllers\DatabaseController;


    require_once '../../../config/config.php';
    require_once '../../components/navbar.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      
    require_once __DIR__ . '../../../../app/Http/Controllers/core/databasecontroller.php';
    $db = DatabaseController::getInstance();
    $db->init();
    $pdo = $db->getConnection();

    // Collect values
    $projectTitle = $_POST['project-title'];
    $serialNumber = $_POST['project-serial-number'];
    $description = $_POST['project-description'];
    $startDate = $_POST['project-start-date'];
    $endDate = $_POST['project-End-date'];

    // Client
    $clientName = $_POST['client-name'];
    $clientCompany = $_POST['client-company'];
    $clientEmail = $_POST['client-email'];
    $clientPhone = $_POST['client-phone'];

    // Supplier
    $supplierName = $_POST['supplier-name'];
    $supplierCompany = $_POST['supplier-company'];
    $supplierEmail = $_POST['supplier-email'];
    $supplierPhone = $_POST['supplier-phone'];

    try {
        // Insert client
        $stmt = $pdo->prepare("INSERT INTO Client (client_name, company_name, email, client_phone_number) VALUES (?, ?, ?, ?)");
        $stmt->execute([$clientName, $clientCompany, $clientEmail, $clientPhone]);
        $clientId = $pdo->lastInsertId();

        // Insert supplier
        $stmt = $pdo->prepare("INSERT INTO Supplier (supplier_name, company_name, email, supplier_phone_number) VALUES (?, ?, ?, ?)");
        $stmt->execute([$supplierName, $supplierCompany, $supplierEmail, $supplierPhone]);
        $supplierId = $pdo->lastInsertId();

        // Insert project
        $stmt = $pdo->prepare("INSERT INTO Project (
            serial_number, supplier_id, client_id, project_name, project_description, 
            start_date, end_date, buffered_date, buffer_days, status
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->execute([
            $serialNumber,
            $supplierId,
            $clientId,
            $projectTitle,
            $description,
            $startDate,
            $endDate,
            $endDate,      // buffered_date same as end_date initially
            0,             // buffer_days
            'prospecting'  // status
        ]);

        echo "<p style='color:green; text-align:center;'>✅ Project created successfully.</p>";
    } catch (PDOException $e) {
        echo "<p style='color:red; text-align:center;'>❌ Failed: " . $e->getMessage() . "</p>";
    }
}
?>

    <form class="project-form" method="POST" action="">
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

      <div class="date-picker-container">
        <button type="button" onclick="document.getElementById('project-start-date').showPicker()">
          <div class="date-label">Project Start Date<span class="required">*</span></div>
          <i class="fas fa-calendar-alt calendar-icon"></i>
          <input type="date" id="project-start-date" name="project-start-date" class="hidden-date-input" required />
        </button>
      </div>

      <div class="date-picker-container">
        <button type="button" onclick="document.getElementById('project-End-date').showPicker()">
          <div class="date-label">Project End Date<span class="required">*</span></div>
          <i class="fas fa-calendar-alt calendar-icon"></i>
          <input type="date" id="project-End-date" name="project-End-date" class="hidden-date-input" required />
        </button>
      </div>


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

      <div class="suplier-button">
        <button type="button" id="supplierButton" class="add-supplier-btn">
          Add Another Supplier <i class="fas fa-plus"></i>
        </button>
      </div>

      <div class="bottom-buttons">
        <div class="date-picker-container">
          <button type="button" onclick="document.getElementById('supplier-date').showPicker()">
            <div class="date-label">Suplier Date<span class="required">*</span></div>
            <i class="fas fa-calendar-alt calendar-icon"></i>
            <input type="date" id="supplier-date" class="hidden-date-input" />
          </button>
        </div>

        <div class="date-picker-container">
          <button type="button">
            <div class="date-label">Add Media</div>
            <i class="fas fa-plus media-icon"></i>
          </button>
        </div>


      </div>
      <p class="required-note"><span class="required">*</span> Required field</p>
      <div class="form-actions">
        <button type="button" class="form-button cancel-button">Cancel</button>
        <button type="submit" class="form-button create-button">Create</button>
      </div>
    </form>
  </main>


  <div id="confirmationPopup" class="popup-overlay">
    <div class="popup-box">
      <p>You are creating a project. Please make sure the information provided is correct.</p>
      <div class="popup-buttons">
        <button id="cancelPopup" class="orange-btn small">Cancel</button>
        <button id="confirmPopup" class="orange-btn small">Confirm</button>
      </div>
    </div>
  </div>
  <script src="../../js/createProject.js"></script>
</body>

</html>