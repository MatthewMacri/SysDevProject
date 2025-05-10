<?php

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