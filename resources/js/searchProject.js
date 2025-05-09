
document.addEventListener('DOMContentLoaded', function () {
    document.querySelector('.project-search-box').addEventListener('submit', function (e) {
      e.preventDefault();
      
      const serial = document.getElementById('serialNumber').value.trim().toLowerCase();
      const resultsContainer = document.getElementById('results');
      resultsContainer.innerHTML = ""; // Clear previous results
  
      fetch('../../app/Http/Controllers/projectcontroller.php')
        .then(res => res.json())
        .then(data => {
          const matches = data.filter(project => project.serialNumber.toLowerCase() === serial);
  
          if (matches.length === 0) {
            resultsContainer.innerHTML = "<p>No matching project found.</p>";
            return;
          }
  
          matches.forEach(project => {
            const card = `
              <div class="result-card">
                <div class="result-header">
                  <div>
                    <strong>${project.serialNumber}</strong><br>
                    <span>${project.title}</span><br>
                    <small>${project.description}</small>
                  </div>
                  <div class="project-status">${project.status}</div>
                </div>
                <div class="button-row">
                  <div class="left-buttons">
                    <button class="action-button">Update</button>
                    <button class="action-button">Delete</button>
                    <button class="action-button">History</button>
                  </div>
                  <div class="right-button">
                    <button class="action-button">Export as PDF</button>
                  </div>
                </div>
              </div>
            `;
            resultsContainer.insertAdjacentHTML('beforeend', card);
          });
        });
    });
  });