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
    <a href="/SysDevProject/resources/views/project/searchProject.php">Project Search</a>
    <a href="/SysDevProject/resources/views/project/history.php">Project History</a>
    <a href="/SysDevProject/resources/views/project/createProjectView.php">Create Project</a>
    <a href="/SysDevProject/resources/views/other/statusOverview.php">Status Overview</a>
  </div>

  <a class="logo-container" href="#">
    <img src="/SysDevProject/public/images/logo/New_TGE_Logo_2025.png" alt="Logo" class="logo">
  </a>

  <div class="nav-right">
    <div class="search-box">
      <input type="text" placeholder="Search">
      <button><i class="fa-solid fa-magnifying-glass"></i></button>
    </div>
<a href="/SysDevProject/logout.php">
  <button class="logout-btn">Logout</button>
</a>
    <div class="dropdown">
      <span class="dropdown-icon"><i class="fa-regular fa-user"></i></span>
      <div class="dropdown-content">
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
          <a href="/SysDevProject/resources/views/admin/adminChangePassword.php">Manage</a>
          <a href="/SysDevProject/resources/views/admin/createUser.php">Create</a>
          <a href="/SysDevProject/resources/views/project/deleteProject.php">Delete</a>
          <a href="/SysDevProject/resources/views/admin/userActivation.php">User Status</a>
          <a href="/SysDevProject/resources/views/project/archive.php">Project Archive</a>
        <?php else: ?>
          <a href="/SysDevProject/resources/views/admin/adminChangePassword.php">Manage</a>
          <a href="/SysDevProject/resources/views/project/archive.php">Project Archive</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>