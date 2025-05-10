<?php
header('Content-Type: application/json');

$db = new SQLite3('../../database/Datab.db');
$data = json_decode(file_get_contents("php://input"), true);

$taskId = $data['task_id'] ?? null;

if ($taskId) {
    $stmt = $db->prepare("DELETE FROM tasks WHERE id = :id");
    $stmt->bindValue(':id', $taskId, SQLITE3_INTEGER);
    $result = $stmt->execute();

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to delete task.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Missing task_id']);
}