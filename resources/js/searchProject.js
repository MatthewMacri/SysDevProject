// Wait for the entire page to load first
document.addEventListener('DOMContentLoaded', function () {

  // When the search form is submitted
  document.querySelector('.project-search-box').addEventListener('submit', function (e) {
    e.preventDefault(); // Stop the form from refreshing the page

    // Get all the input values and clean them up (remove extra spaces)
    const serial = document.getElementById('serialNumber').value.trim();
    const title = document.getElementById('projectTitle').value.trim();
    const status = document.getElementById('projectStatus').value.trim();
    const supplier = document.getElementById('supplierName').value.trim();
    const client = document.getElementById('clientName').value.trim();

    // Select the container where results will show
    const resultsContainer = document.getElementById('results');
    resultsContainer.innerHTML = ""; // Clear anything from a previous search

    // Build the URL with parameters based on user input
    const params = new URLSearchParams();
    if (serial) params.append('serialNumber', serial);
    if (title) params.append('projectTitle', title);
    if (status) params.append('projectStatus', status);
    if (supplier) params.append('supplierName', supplier);
    if (client) params.append('clientName', client);

    // Send request to the backend PHP (this returns a JSON response)
    fetch(`/SysDevProject/index.php?controller=project&action=searchJson&${params.toString()}`)
      .then(res => {
        if (!res.ok) throw new Error('Failed to fetch project data');
        return res.json(); // Turn the response into JSON
      })
      .then(data => {
        // If nothing is found, let the user know
        if (!data || data.length === 0) {
          resultsContainer.innerHTML = "<p>No matching projects found.</p>";
          return;
        }

        // Loop through each project and create a card for it
        data.forEach(project => {
          const card = `
             <div class="result-card">
              <div class="result-header">
                <div>
                  <strong>${project.serial_number}</strong><br>
                  <span>${project.project_name}</span><br>
                  <small>${project.project_description}</small><br>
                  <small>Client: ${project.client_name}</small><br>
                  <small>Supplier: ${project.supplier_name}</small>
                </div>
                <div class="project-status">${project.status}</div>
              </div>
              <div class="button-row">
                <div class="left-buttons">
                  <a class="action-button" href="/SysDevProject/resources/views/project/updateProject.php?serial=${project.serial_number}">Update</a>

                  <form method="POST" style="display:inline;">
                    <input type="hidden" name="delete_serial" value="${project.serial_number}">
                    <button type="submit" class="action-button" onclick="return confirm('Are you sure you want to delete this project?');">Delete</button>
                  </form>

                  <a class="action-button">History</a>
                </div>
                <div class="right-button">
                  <button class="action-button">Export as PDF</button>
                </div>
              </div>
            </div>
          `;

          // Add the card to the page
          resultsContainer.insertAdjacentHTML('beforeend', card);
        });
      })
      .catch(error => {
        // Show error if something went wrong with the fetch
        console.error("Error fetching projects:", error);
        resultsContainer.innerHTML = "<p>An error occurred while searching. Check console for details.</p>";
      });
  });

});