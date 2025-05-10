<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
$username = trim($data['username'] ?? '');

if (!$username) {
  echo json_encode(["success" => false, "message" => "Username required"]);
  exit;
}

// Simulate sending email to admin
$adminEmail = "admin@example.com";
$subject = "Password Reset Request";
$body = "User '$username' has requested a password reset.";

mail($adminEmail, $subject, $body); // Replace or mock in dev

echo json_encode(["success" => true]);
?>