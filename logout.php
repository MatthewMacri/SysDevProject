<?php
session_start();
session_unset();
session_destroy();
setcookie("auth", "", time() - 3600, "/");
header("Location: resources/views/login/loginview.php");
exit;
?>