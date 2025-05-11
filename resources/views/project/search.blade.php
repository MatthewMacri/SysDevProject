<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Project Search</title>
  <link rel="icon" type="image/png" href="/SysDevProject/public/images/logo/favicon-gear.png" />

  <link rel="stylesheet" href="../../css/searchProject.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

  <!-- Shared Navbar Include -->
  <?php 
  require_once $_SERVER['DOCUMENT_ROOT'] . '/SysDevProject/config/config.php';
  @include 'components.navbar';
  ?>

  <main>
    <div class="Search-container" style="margin-top: 40px;">
      <form class="project-search-box" method="GET" action="{{ route('projects.search') }}">
        <div class="form-group">
          <label for="serialNumber">Serial Number</label>
          <input type="text" id="serialNumber" name="serialNumber" style="height: 25px;">
        </div>

        <div class="form-group">
          <label for="projectTitle">Project Title</label>
          <input type="text" id="projectTitle" name="projectTitle" style="height: 25px;">
        </div>

        <div class="form-group">
          <label for="projectStatus">Project Status</label>
          <input type="text" id="projectStatus" name="projectStatus" style="height: 25px;">
        </div>

        <div class="form-group">
          <label for="supplierName">Supplier Name</label>
          <input type="text" id="supplierName" name="supplierName" style="height: 25px;">
        </div>

        <div class="form-group">
          <label for="clientName">Client Name</label>
          <input type="text" id="clientName" name="clientName" style="height: 25px;">
        </div>

        <div class="form-group button-wrapper">
          <button type="submit" class="orange-button">Search Project</button>
        </div>
      </form>
    </div>

    <div id="results"></div>

    <!-- <div class="result-card">
      <div class="result-header">
        <div>
          <strong>Project Serial Number</strong><br>
          <span>Example Project Title</span><br>
          <small>Very Brief Description</small>
        </div>
        <div class="project-status">Project Status</div>
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
    </div> -->
    <div id="results">
  @if(isset($projects) && count($projects))
    @foreach($projects as $project)
      <div class="result-card">
        <div class="result-header">
          <div>
            <strong>{{ $project->serialNumber }}</strong><br>
            <span>{{ $project->title }}</span><br>
            <small>{{ $project->description }}</small>
          </div>
          <div class="project-status">{{ $project->status }}</div>
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
    @endforeach
  @elseif(request()->all())
    <p>No matching projects found.</p>
  @endif
</div>
  </main>

  <script src="../../js/searchProject.js"></script>

  <!-- Full Logout Script -->
  <script src="https://www.w3schools.com/lib/w3data.js"></script>
  <script>
    w3IncludeHTML(function () {
      const logoutBtn = document.querySelector(".logout-btn");
      if (logoutBtn) {
        logoutBtn.addEventListener("click", () => {
          fetch("/SysDevProject/logout.php", {
            method: "POST",
            credentials: "include"
          })
          .then(res => res.json())
          .then(data => {
            if (data.success) {
              document.cookie = "auth=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
              window.location.href = "/SysDevProject/resources/views/login.html";
            } else {
              alert("Logout failed");
            }
          })
          .catch(err => {
            console.error("Logout error:", err);
            alert("Logout request failed.");
          });
        });
      }
    });
  </script>
</body>
</html>