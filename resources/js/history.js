document.getElementById('searchBtn').addEventListener('click', () => {
    const input = document.getElementById('serialInput').value.trim();
    const results = document.getElementById('historyResults');

    fetch('../../jsonData/projects.json')
      .then(res => res.json())
      .then(data => {
        const match = data.find(p => p.serialNumber === input);

        if (!match) {
          results.innerHTML = `<p>No project found with serial number ${input}.</p>`;
          return;
        }

        if (!match.history || match.history.length === 0) {
          results.innerHTML = `<p>No history available for project ${match.serialNumber}.</p>`;
          return;
        }

        results.innerHTML = `<p>History of modifications of project ${match.serialNumber}:</p>`;
        match.history.forEach(entry => {
          results.innerHTML += `<p>${entry}</p>`;
        });
      })
      .catch(err => {
        results.innerHTML = "<p>Error loading project data.</p>";
        console.error(err);
      });
  });