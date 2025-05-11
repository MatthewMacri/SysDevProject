<?php
// Return JSON response
header('Content-Type: application/json');

// Read and decode incoming JSON data
$data = json_decode(file_get_contents("php://input"), true);
$username = trim($data['username'] ?? '');

// Validate input
if (!$username) {
    echo json_encode([
        "success" => false,
        "message" => "Username required"
    ]);
    exit;
}

// Email details
$adminEmail = "admin@example.com"; // Replace with real admin address
$subject = "Password Reset Request";
$body = "User '$username' has requested a password reset.";

// Send email (in production, use a mailer library or SMTP)
$mailSent = mail($adminEmail, $subject, $body);

// Return response
if ($mailSent) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Failed to send email. Check mail server configuration."
    ]);
}