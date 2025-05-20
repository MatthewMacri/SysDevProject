<?php
use App\Http\Controllers\core\DatabaseController;

// Set JSON response header
header('Content-Type: application/json');

// Connect to the SQLite database
$database = DatabaseController::getInstance();
$db = $database->getConnection();

// Decode JSON input
$data = json_decode(file_get_contents("php://input"), true);

// Sanitize and validate input
$title = trim($data['title'] ?? '');
$status = trim($data['status'] ?? '');

// Check required fields
if ($title && $status) {
    // Prepare the SQL statement with bound parameters to prevent SQL injection
    $stmt = $db->prepare("INSERT INTO tasks (title, status) VALUES (:title, :status)");
    $stmt->bindValue(':title', $title, SQLITE3_TEXT);
    $stmt->bindValue(':status', $status, SQLITE3_TEXT);

    // Execute and respond accordingly
    $result = $stmt->execute();

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'Database insert failed'
        ]);
    }

} else {
    // If title or status is missing, return error
    echo json_encode([
        'success' => false,
        'error' => 'Missing title or status'
    ]);
}