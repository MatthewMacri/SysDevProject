fetch('../jsonData/projects.json')
      .then(res => res.json())
      .then(data => {
        const project = data[2]; 
  
        document.getElementById('projectTitle').textContent = project.title;
        document.getElementById('projectSerial').textContent = `Project ${project.serialNumber}`;
        document.getElementById('projectStatus').textContent = project.status;
        document.getElementById('projectDescription').textContent = project.description;
  
        document.getElementById('clientDetails').textContent = `Client Details: ${project.clientDetails}`;
        document.getElementById('supplierInfo').textContent = `Supplier Info: ${project.supplierInfo}`;
        document.getElementById('supplierDate').textContent = `Supplier date: ${project.supplierDate}`;
        document.getElementById('clientDate').textContent = `Client date: ${project.clientDate}`;
        document.getElementById('bufferDays').textContent = `Buffer days (slack time): ${project.bufferDays} days`;
  
        const mediaContainer = document.getElementById('mediaButtons');
        mediaContainer.innerHTML = ''; 
  

      })
      .catch(error => {
        console.error("Failed to load project data:", error);
      });


      document.addEventListener('DOMContentLoaded', () => {
        const popup = document.getElementById('popup');
        const deleteBtn = document.querySelector('.delete-button');
        const cancelBtn = document.getElementById('cancelPopup');
        const confirmBtn = document.getElementById('confirmPopup');
        const passwordInput = document.getElementById('passwordInput');
      
        deleteBtn.addEventListener('click', (e) => {
          e.preventDefault(); 
          passwordInput.value = '';
          popup.style.display = 'flex';
        });
      
        cancelBtn.addEventListener('click', () => {
          popup.style.display = 'none';
          passwordInput.value = '';
        });
      
        confirmBtn.addEventListener('click', () => {
          const password = passwordInput.value.trim();
      
          if (!password) {
            alert("Please enter your password.");
            return;
          }
           popup.style.display = 'none';
        });
      });
      