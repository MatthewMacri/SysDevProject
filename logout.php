<?php
// Start the session so we can access and destroy it
session_start();

// Remove all session variables
session_unset();

// Destroy the session completely
session_destroy();

// Clear the "auth" cookie by setting its expiration time in the past
setcookie("auth", "", time() - 3600, "/");
echo json_encode(["success" => true]);
header("Location: resources/views/login/loginview.php");
exit;
?>
