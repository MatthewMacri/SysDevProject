let supplierCount = 1;
const maxSuppliers = 5;

document.addEventListener("DOMContentLoaded", function () {
  // FORM CONFIRMATION POPUP LOGIC
  const form = document.querySelector('.project-form');
  const popup = document.getElementById('confirmationPopup');
  const cancelBtn = document.getElementById('cancelPopup');
  const confirmBtn = document.getElementById('confirmPopup');

  if (form && popup && cancelBtn && confirmBtn) {
    form.addEventListener('submit', function (e) {
      e.preventDefault(); // Prevent actual submit
      popup.style.display = 'flex'; // Show confirmation modal
    });

    cancelBtn.addEventListener('click', function () {
      popup.style.display = 'none'; // Hide on cancel
    });

    confirmBtn.addEventListener('click', function () {
      popup.style.display = 'none';
      form.submit(); // Proceed with submit after confirmation
    });
  } else {
    console.warn("Some form modal elements are missing. Skipping modal setup.");
  }

  // ------------------------------
  // ADD SUPPLIER DYNAMICALLY
  // ------------------------------
  const supplierButton = document.getElementById('supplierButton');
  const supplierContainer = document.getElementById('supplier-sections');

  if (supplierButton && supplierContainer) {
    supplierButton.addEventListener('click', function () {
      if (supplierCount >= maxSuppliers) {
        alert("You can only add up to 5 suppliers.");
        return;
      }

      // Create a new supplier input block
      const newSupplier = document.createElement('div');
      newSupplier.classList.add('form-section', 'supplier-details');
      newSupplier.innerHTML = `
        <h2>Supplier Details</h2>
        <div class="form-group">
          <label>Supplier Name<span class="required">*</span></label>
          <input type="text" name="supplier-name" required>
        </div>
        <div class="form-group">
          <label>Company Name<span class="required">*</span></label>
          <input type="text" name="supplier-company" required>
        </div>
        <div class="form-group">
          <label>Email<span class="required">*</span></label>
          <input type="email" name="supplier-email" required>
        </div>
        <div class="form-group">
          <label>Phone Number<span class="required">*</span></label>
          <input type="tel" name="supplier-phone" required>
        </div>
      `;

      supplierContainer.appendChild(newSupplier);
      supplierCount++;
    });
  } else {
    console.warn("Supplier button or container not found. Skipping supplier logic.");
  }
});