document.addEventListener('DOMContentLoaded', function () {
  document.querySelector('.project-search-box').addEventListener('submit', function (e) {
    e.preventDefault();

    const serial = document.getElementById('serialNumber').value.trim();
    const title = document.getElementById('projectTitle').value.trim();
    const status = document.getElementById('projectStatus').value.trim();
    const supplier = document.getElementById('supplierName').value.trim();
    const client = document.getElementById('clientName').value.trim();

    const resultsContainer = document.getElementById('results');
    resultsContainer.innerHTML = ""; // Clear previous results

    // Build URL parameters
    const params = new URLSearchParams();
    if (serial) params.append('serialNumber', serial);
    if (title) params.append('projectTitle', title);
    if (status) params.append('projectStatus', status);
    if (supplier) params.append('supplierName', supplier);
    if (client) params.append('clientName', client);

    // Fetch from the proper JSON endpoint via index.php router
    fetch(`/SysDevProject/index.php?controller=project&action=searchJson&${params.toString()}`)
      .then(res => {
        if (!res.ok) throw new Error('Failed to fetch project data');
        return res.json();
      })
      .then(data => {
        if (!data || data.length === 0) {
          resultsContainer.innerHTML = "<p>No matching projects found.</p>";
          return;
        }

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
      })
      .catch(error => {
        console.error("Error fetching projects:", error);
        resultsContainer.innerHTML = "<p>An error occurred while searching. Check console for details.</p>";
      });
  });
});