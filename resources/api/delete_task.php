<?php
// Set response header for JSON
header('Content-Type: application/json');

// Connect to SQLite database
$db = new SQLite3('../../database/Datab.db');

// Decode incoming JSON data
$data = json_decode(file_get_contents("php://input"), true);

// Get task ID
$taskId = $data['task_id'] ?? null;

// Validate presence of task ID
if ($taskId) {
    // Prepare and bind parameters securely
    $stmt = $db->prepare("DELETE FROM tasks WHERE id = :id");
    $stmt->bindValue(':id', $taskId, SQLITE3_INTEGER);

    // Execute query
    $result = $stmt->execute();

    // Return result as JSON
    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'Failed to delete task.'
        ]);
    }
} else {
    // Missing task ID in request
    echo json_encode([
        'success' => false,
        'error' => 'Missing task_id'
    ]);
}