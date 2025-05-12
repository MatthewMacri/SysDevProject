<?php
// Check if SQLite3 extension is enabled
if (!class_exists('SQLite3')) {
    http_response_code(500);
    echo json_encode([
        'error' => 'SQLite3 extension is not enabled. Please enable it in php.ini by removing the semicolon (;) from extension=sqlite3'
    ]);
    exit;
}

// Enable full error reporting for debugging (development only)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set response content type
header('Content-Type: application/json');

// Connect to SQLite database
$db = new SQLite3('C:/xampp/htdocs/SysDevProject/database/Datab.db');

// Query all tasks
$result = $db->query("SELECT id, title, status FROM tasks");

// Define columns for Kanban statuses
$columns = [
    'PROSPECTING' => [],
    'IN PROGRESS' => [],
    'HOLD' => [],
    'COMPLETED' => []
];

// Process result and group tasks by status
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $status = strtoupper(trim($row['status']));

    // Skip unknown statuses gracefully
    if (!array_key_exists($status, $columns)) {
        continue;
    }

    $columns[$status][] = [
        'id' => 'task-' . $row['id'],
        'title' => $row['title']
    ];
}

// Return grouped tasks as JSON
echo json_encode($columns);