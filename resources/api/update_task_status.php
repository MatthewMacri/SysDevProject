<?php
// Return JSON response
header('Content-Type: application/json');

// Ensure the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

// Parse JSON input
$data = json_decode(file_get_contents('php://input'), true);

// Validate required fields
if (!isset($data['task_id'], $data['new_status'])) {
    echo json_encode(['success' => false, 'message' => 'Missing task_id or new_status']);
    exit;
}

// Extract and sanitize data
$taskId = str_replace('task-', '', $data['task_id']);  // Strip prefix if used in frontend
$newStatus = strtoupper(trim($data['new_status']));    // Normalize status text

// Connect to SQLite database
$db = new SQLite3('C:/xampp/htdocs/SysDevProject/database/Datab.db');

// Prepare SQL update statement securely
$stmt = $db->prepare("UPDATE tasks SET status = :status WHERE id = :id");
$stmt->bindValue(':status', $newStatus, SQLITE3_TEXT);
$stmt->bindValue(':id', (int)$taskId, SQLITE3_INTEGER);

// Execute and return result
if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Database update failed']);
}