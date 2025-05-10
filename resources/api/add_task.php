<?php
header('Content-Type: application/json');

// Connect to the database
$db = new SQLite3('../../database/Datab.db');

// Read input JSON
$data = json_decode(file_get_contents("php://input"), true);
$title = trim($data['title'] ?? '');
$status = trim($data['status'] ?? '');

if ($title && $status) {
    $stmt = $db->prepare("INSERT INTO tasks (title, status) VALUES (:title, :status)");
    $stmt->bindValue(':title', $title, SQLITE3_TEXT);
    $stmt->bindValue(':status', $status, SQLITE3_TEXT);
    $result = $stmt->execute();

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'DB insert failed']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Missing title or status']);
}