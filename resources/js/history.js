document.getElementById('searchBtn').addEventListener('click', () => {
  const input = document.getElementById('serialInput').value.trim();
  const results = document.getElementById('historyResults');

  // Clear previous results
  results.innerHTML = '';

  if (!input) {
    results.innerHTML = `<p>Please enter a serial number.</p>`;
    return;
  }

  fetch('../../jsonData/projects.json')
    .then(res => res.json())
    .then(data => {
      const match = data.find(p => p.serialNumber === input);

      if (!match) {
        results.innerHTML = `<p>No project found with serial number <strong>${input}</strong>.</p>`;
        return;
      }

      if (!Array.isArray(match.history) || match.history.length === 0) {
        results.innerHTML = `<p>No history available for project <strong>${match.serialNumber}</strong>.</p>`;
        return;
      }

      // Display history
      const historyHTML = `
        <p>History of modifications for project <strong>${match.serialNumber}</strong>:</p>
        <ul>
          ${match.history.map(entry => `<li>${entry}</li>`).join('')}
        </ul>
      `;
      results.innerHTML = historyHTML;
    })
    .catch(err => {
      console.error("Fetch error:", err);
      results.innerHTML = `<p style="color:red;">Error loading project data.</p>`;
    });
});