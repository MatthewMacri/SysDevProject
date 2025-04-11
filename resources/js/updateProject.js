fetch('../../jsonData/projects.json')
    .then(res => res.json())
    .then(data => {
      const project = data[2]; 

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
        console.error("Failed to load project data:", error);
      });

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