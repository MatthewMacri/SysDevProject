let supplierCount = 1;
const maxSuppliers = 5;

document.addEventListener("DOMContentLoaded", function () {
  // CONFIRMATION POPUP FORM LOGIC
  const form = document.querySelector('.project-form');
  const popup = document.getElementById('confirmationPopup');
  const cancelBtn = document.getElementById('cancelPopup');
  const confirmBtn = document.getElementById('confirmPopup');
  const openConfirmationBtn = document.getElementById('openConfirmation');

  if (form && popup && cancelBtn && confirmBtn && openConfirmationBtn) {
    openConfirmationBtn.addEventListener('click', function () {
      popup.style.display = 'flex';
    });

    cancelBtn.addEventListener('click', function () {
      popup.style.display = 'none';
    });

    confirmBtn.addEventListener('click', function () {
      popup.style.display = 'none';
      form.submit();
    });
  } else {
    console.warn("Missing modal or button elements for confirmation.");
  }

  // ADD SUPPLIER DYNAMICALLY
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

  // DATE VALIDATION AND DISPLAY
  const startInput = document.getElementById("project-start-date");
  const endInput = document.getElementById("project-End-date");
  const supplierInput = document.getElementById("supplier-date");

  function formatDate(dateStr) {
    const d = new Date(dateStr);
    return d.toLocaleDateString(undefined, {
      year: "numeric", month: "long", day: "numeric"
    });
  }

  function updateDateDisplay(input, reset = false) {
    const container = input.closest(".date-picker-container");
    const label = container.querySelector(".date-label");

    if (reset || !input.value) {
      if (input.id === "project-start-date") {
        label.innerHTML = 'Project Start Date<span class="required">*</span>';
      } else if (input.id === "project-End-date") {
        label.innerHTML = 'Project End Date<span class="required">*</span>';
      }
      return;
    }

    label.innerHTML = `<strong>${formatDate(input.value)}</strong>`;
  }

  function validateDates() {
    const startDate = new Date(startInput.value);
    const endDate = new Date(endInput.value);
    const today = new Date();
    today.setHours(0, 0, 0, 0);

    if (startInput.value && startDate < today) {
      alert("Start date cannot be in the past.");
      startInput.value = "";
      updateDateDisplay(startInput, true);
      return false;
    }

    if (startInput.value && endInput.value && endDate < startDate) {
      alert("End date cannot be before start date.");
      endInput.value = "";
      updateDateDisplay(endInput, true);
      return false;
    }

    return true;
  }

  startInput.addEventListener("change", () => {
    updateDateDisplay(startInput);
    validateDates();
  });

  endInput.addEventListener("change", () => {
    updateDateDisplay(endInput);
    validateDates();
  });

  function updateSupplierDateDisplay(reset = false) {
    const container = supplierInput.closest(".date-picker-container");
    const label = container.querySelector(".date-label");

    if (reset || !supplierInput.value) {
      label.innerHTML = 'Supplier Date<span class="required">*</span>';
      return;
    }

    label.innerHTML = `<strong>${formatDate(supplierInput.value)}</strong>`;
  }

  function validateSupplierDate() {
    if (!supplierInput || !supplierInput.value) return true;

    const selected = new Date(supplierInput.value);
    const today = new Date();
    today.setHours(0, 0, 0, 0);

    if (selected < today) {
      alert("Supplier date cannot be in the past.");
      supplierInput.value = "";
      updateSupplierDateDisplay(true);
      return false;
    }

    return true;
  }

  supplierInput.addEventListener("change", () => {
    updateSupplierDateDisplay();
    validateSupplierDate();
  });

  // ENABLE CLICK TO OPEN CALENDAR FOR ALL
  document.querySelectorAll(".date-picker-container button").forEach(button => {
    button.addEventListener("click", function () {
      const input = this.querySelector("input[type='date']");
      input.showPicker();
    });
  });

  // --- FORM STATE SAVING TO LOCALSTORAGE ---
  const fields = form.querySelectorAll("input, textarea");
  // Load saved data
  fields.forEach(field => {
    const saved = localStorage.getItem(field.name);
    if (saved) field.value = saved;
  });

  // Save data on input
  fields.forEach(field => {
    field.addEventListener("input", () => {
      localStorage.setItem(field.name, field.value);
    });
  });

  // Clear on submit if valid
  form.addEventListener("submit", function (e) {
    if (!validateDates() || !validateSupplierDate()) {
      e.preventDefault(); // Prevent database write
    } else {
      fields.forEach(field => localStorage.removeItem(field.name));
    }
  });
});