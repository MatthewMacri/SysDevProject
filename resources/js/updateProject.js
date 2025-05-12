// ======================================
// Load project data from a JSON file
// ======================================
fetch('../../jsonData/projects.json')
  .then(res => res.json())
  .then(data => {
    //  Pick the third project from the array (index 2)
    const project = data[2];

    //  Fill in the form fields with the project info
    document.getElementById('projectTitle').value = project.title;
    document.getElementById('projectSerial').textContent = `Project ${project.serialNumber}`;
    document.getElementById('projectStatus').value = project.status;
    document.getElementById('projectDescription').value = project.description;

    document.getElementById('clientDetails').value = project.clientDetails;
    document.getElementById('supplierInfo').value = project.supplierInfo;
    document.getElementById('supplierDate').value = project.supplierDate;
    document.getElementById('clientDate').value = project.clientDate;
    document.getElementById('bufferDays').value = project.bufferDays;
  })
  .catch(error => {
    //  Something went wrong with loading the JSON file
    console.error("Failed to load project data:", error);
  });


// Confirmation Popup for Submitting Form
document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector('.project-form');
  const popup = document.getElementById('confirmationPopup');
  const cancelBtn = document.getElementById('cancelPopup');
  const confirmBtn = document.getElementById('confirmPopup');

  // When the form is submitted, show the confirmation popup instead
  form.addEventListener('submit', function (e) {
    e.preventDefault(); // Stop the default form submission
    popup.style.display = 'flex'; // Show the modal
  });

  // Cancel button closes the popup
  cancelBtn.addEventListener('click', function () {
    popup.style.display = 'none';
  });

  // Confirm button submits the form
  confirmBtn.addEventListener('click', function () {
    popup.style.display = 'none';
    form.submit(); // Now actually submit the form
  });
});