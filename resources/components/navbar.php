<?php
require_once dirname(__DIR__, 1) . '/services/i18n.php';
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';
$app = require_once dirname(__DIR__, 2) . '/bootstrap/app.php';

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
if (!isset($_SESSION['role'])) {
  header("Location: SysDevProject/resources/views/login/loginview.php");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['lang'])) {
  $_SESSION['locale'] = $_POST['lang'];
}

$locale = $_SESSION['locale'] ?? 'en_US';

putenv("LC_ALL=$locale");
setlocale(LC_ALL, $locale);
bindtextdomain("messages", dirname(__DIR__, 2) . '/resources/lang/locale');
bind_textdomain_codeset("messages", "UTF-8");
textdomain("messages");
?>

<!-- Include external CSS for navbar -->
<style>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/SysDevProject/resources/css/navbar.css'; ?>
</style>

<!-- Navbar Component -->
<div class="navbar">
  <!-- Left Navigation Links -->
  <div class="nav-left">
    <a href="/SysDevProject/resources/views/home.php" class="active"> <?php echo _('Home'); ?></a>
    <a href="/SysDevProject/resources/views/project/searchProject.php"><?php echo _('Project Search'); ?></a>
    <a href="/SysDevProject/resources/views/project/history.php"><?php echo _('Project History'); ?></a>
    <a href="/SysDevProject/resources/views/project/createProjectView.php"><?php echo _('Create Project'); ?></a>
    <a href="/SysDevProject/resources/views/statusOverview.php"><?php echo _('Status Overview'); ?></a>
  </div>

  <!-- Center Logo -->
  <a class="logo-container" href="/SysDevProject/resources/views/home.php">
    <img src="/SysDevProject/public/images/logo/New_TGE_Logo_2025.png" alt="Logo" class="logo">
  </a>

  <!-- Right-side Utilities -->
  <div class="nav-right">
    <!-- Search Box -->
    <div class="search-box">
      <input type="text" placeholder="<?php echo _('Search'); ?>">
      <button><i class="fa-solid fa-magnifying-glass"></i></button>
    </div>

    <!-- Logout Button -->
    <a href="/SysDevProject/logout.php">
      <button class="logout-btn"><?php echo _('Logout'); ?></button>
    </a>

    <!-- User Role Dropdown Menu -->
    <div class="dropdown">
      <span class="dropdown-icon"><i class="fa-regular fa-user"></i></span>
      <div class="dropdown-content">
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
          <form method="POST">
            <select name="lang" onchange="this.form.submit()">
              <option value="en_US" <?= ($_SESSION['locale'] ?? '') === 'en_US' ? 'selected' : '' ?>>English</option>
              <option value="fr_FR" <?= ($_SESSION['locale'] ?? '') === 'fr_FR' ? 'selected' : '' ?>>Français</option>
            </select>
          </form>
          <a href="/SysDevProject/resources/views/admin/adminChangePassword.php"><?php echo _('Manage Password'); ?></a>
          <a href="/SysDevProject/resources/views/admin/createUser.php"><?php echo _('Create User'); ?></a>
          <a href="/SysDevProject/resources/views/user/deleteUser.php"><?php echo _('Delete User'); ?></a>
          <a href="/SysDevProject/resources/views/admin/userActivation.php"><?php echo _('User Status'); ?></a>
          <a href="/SysDevProject/resources/views/project/archive.php"><?php echo _('Project Archive'); ?></a>
        <?php else: ?>
          <a href="/SysDevProject/resources/views/user/changePassword.php"><?php echo _('Manage Password'); ?></a>
          <a href="/SysDevProject/resources/views/project/archive.php"><?php echo _('Project Archive'); ?></a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>