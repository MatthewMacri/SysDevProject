<?php

if (!class_exists('SQLite3')) {
    http_response_code(500);
    echo json_encode([
        'error' => 'SQLite3 extension is not enabled. Please enable it in your php.ini file: remove the semicolon (;) from extension=sqlite3'
    ]);
    exit;
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

header('Content-Type: application/json');

$db = new SQLite3('C:/xampp/htdocs/SysDevProject/database/Datab.db');

$result = $db->query("SELECT id, title, status FROM tasks");

$columns = ['PROSPECTING' => [], 'IN PROGRESS' => [], 'HOLD' => [], 'COMPLETED' => []];

while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $columns[$row['status']][] = [
        'id' => 'task-' . $row['id'],
        'title' => $row['title']
    ];
}

echo json_encode($columns);