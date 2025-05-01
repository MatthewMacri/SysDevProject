document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector('.project-form');
    const popup = document.getElementById('confirmationPopup');
    const cancelBtn = document.getElementById('cancelPopup');
    const confirmBtn = document.getElementById('confirmPopup');
  
    form.addEventListener('submit', function (e) {
      e.preventDefault(); 
      popup.style.display = 'flex';
    });
  
    cancelBtn.addEventListener('click', function () {
      popup.style.display = 'none';
    });
  
    confirmBtn.addEventListener('click', function () {
      popup.style.display = 'none';
      form.submit(); 
    });
  });


  let supplierCount = 1;
  const maxSuppliers = 5;

  document.addEventListener('DOMContentLoaded', function () {
  document.getElementById('supplierButton').addEventListener('click', function () {

      if (supplierCount >= maxSuppliers) {
          alert("You can only add up to 5 suppliers.");
          return;
      }

    const container = document.getElementById('supplier-sections');

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

    container.appendChild(newSupplier);
    supplierCount++;
  });
});