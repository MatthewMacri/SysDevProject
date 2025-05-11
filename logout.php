<?php
session_start();
session_unset();
session_destroy();
setcookie("auth", "", time() - 3600, "/");
echo json_encode(["success" => true]);
header("Location: resources/views/login/loginview.php");
exit;
?>
