let supplierCount = 1;
const maxSuppliers = 5;

document.addEventListener("DOMContentLoaded", function () {
  // -----------------------------------
  // CONFIRMATION POPUP FORM LOGIC
  // -----------------------------------
  const form = document.querySelector('.project-form');
  const popup = document.getElementById('confirmationPopup');
  const cancelBtn = document.getElementById('cancelPopup');
  const confirmBtn = document.getElementById('confirmPopup');
  const openConfirmationBtn = document.getElementById('openConfirmation');

  if (form && popup && cancelBtn && confirmBtn && openConfirmationBtn) {
    // Open confirmation modal when "Create" button is clicked
    openConfirmationBtn.addEventListener('click', function () {
      popup.style.display = 'flex';
    });

    // Cancel: Close the popup
    cancelBtn.addEventListener('click', function () {
      popup.style.display = 'none';
    });

    // Confirm: Close popup and submit the form
    confirmBtn.addEventListener('click', function () {
      popup.style.display = 'none';
      form.submit();
    });
  } else {
    console.warn("Missing modal or button elements for confirmation.");
  }

  // -----------------------------------
  // ADD SUPPLIER DYNAMICALLY
  // -----------------------------------
  const supplierButton = document.getElementById('supplierButton');
  const supplierContainer = document.getElementById('supplier-sections');

  if (supplierButton && supplierContainer) {
    supplierButton.addEventListener('click', function () {
      if (supplierCount >= maxSuppliers) {
        alert("You can only add up to 5 suppliers.");
        return;
      }

      const newSupplier = document.createElement('div');
      newSupplier.classList.add('form-section', 'supplier-details');
      newSupplier.innerHTML = `
        <h2>Supplier Details</h2>
        <div class="form-group">
          <label>Supplier Name<span class="required">*</span></label>
          <input type="text" name="supplier-name[]" required>
        </div>
        <div class="form-group">
          <label>Company Name<span class="required">*</span></label>
          <input type="text" name="supplier-company[]" required>
        </div>
        <div class="form-group">
          <label>Email<span class="required">*</span></label>
          <input type="email" name="supplier-email[]" required>
        </div>
        <div class="form-group">
          <label>Phone Number<span class="required">*</span></label>
          <input type="tel" name="supplier-phone[]" required>
        </div>
      `;

      supplierContainer.appendChild(newSupplier);
      supplierCount++;
    });
  } else {
    console.warn("Supplier button or container not found.");
  }
});