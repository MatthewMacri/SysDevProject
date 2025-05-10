<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<style>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/SysDevProject/resources/css/navbar.css'; ?>
</style>
<!-- resources/views/navbar.html -->
<div class="navbar">
  <div class="nav-left">
    <a href="/SysDevProject/resources/views/home.php" class="active">Home</a>
    <a href="/SysDevProject/resources/views/project/SearchProject.html">Project Search</a>
    <a href="/SysDevProject/resources/views/project/history.html">Project History</a>
    <a href="/SysDevProject/resources/views/project/CreateProjectView.php">Create Project</a>
    <a href="/SysDevProject/resources/views/statusOverview.html">Status Overview</a>
  </div>

  <a class="logo-container" href="#">
    <img src="/SysDevProject/public/images/logo/New_TGE_Logo_2025.png" alt="Logo" class="logo">
  </a>

  <div class="nav-right">
    <div class="search-box">
      <input type="text" placeholder="Search">
      <button><i class="fa-solid fa-magnifying-glass"></i></button>
    </div>
    <button class="logout-btn">Logout</button>
    <div class="dropdown">
      <span class="dropdown-icon"><i class="fa-regular fa-user"></i></span>
      <div class="dropdown-content">
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
          <a href="/SysDevProject/resources/views/admin/adminChangePassword.html">Manage</a>
          <a href="/SysDevProject/resources/views/admin/createUser.html">Create</a>
          <a href="/SysDevProject/resources/views/project/deleteProject.html">Delete</a>
          <a href="/SysDevProject/resources/views/admin/userActivation.html">User Status</a>
          <a href="/SysDevProject/resources/views/project/archive.html">Project Archive</a>
        <?php else: ?>
          <a href="/SysDevProject/resources/views/admin/adminChangePassword.html">Manage</a>
          <a href="/SysDevProject/resources/views/project/archive.html">Project Archive</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>