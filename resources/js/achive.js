document.addEventListener("DOMContentLoaded", function () {
  const archiveBtn = document.querySelector(".orange-btn");
  const serialInput = document.getElementById("serialInput");
  const archiveList = document.querySelector(".archive-list");

  archiveBtn.addEventListener("click", function () {
    const query = serialInput.value.trim().toLowerCase();
    archiveList.innerHTML = "";

    // Show message if input is empty
    if (!query) {
      archiveList.innerHTML = `<p style="padding: 10px;">No archived projects found.</p>`;
      return;
    }

    fetch("../../jsonData/projects.json")
      .then(res => res.json())
      .then(projects => {
        // Filter archived projects only
        const archived = projects.filter(p => p.archived === true);

        // Further filter by matching serial number
        const filtered = archived.filter(p =>
          p.serialNumber?.toLowerCase().includes(query)
        );

        archiveList.innerHTML = `<h3>List of archived projects</h3>`;

        if (filtered.length === 0) {
          archiveList.innerHTML += `<p style="padding: 10px;">No archived projects found.</p>`;
          return;
        }

        // Render each filtered project as a card
        filtered.forEach(project => {
          const card = `
            <div class="project-card">
              <div>
                <div class="project-header">
                  <p class="serial">${project.serialNumber}</p>
                  <div class="status">${project.status}</div>
                </div>
                <p class="title">${project.title}</p>
                <p class="desc">${project.description?.substring(0, 100) || 'No description'}...</p>
              </div>
              <div class="card-buttons">
                <button class="orange-btn small">History</button>
                <button class="orange-btn small">Unarchive</button>
              </div>
            </div>
          `;
          archiveList.innerHTML += card;
        });
      })
      .catch(err => {
        console.error("Failed to fetch archive data:", err);
        archiveList.innerHTML = `<p style="padding: 10px; color: red;">Failed to load archived projects.</p>`;
      });
  });
});