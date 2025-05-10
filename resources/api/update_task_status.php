<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['task_id'], $data['new_status'])) {
    echo json_encode(['success' => false, 'message' => 'Missing data']);
    exit;
}

$db = new SQLite3('C:/xampp/htdocs/SysDevProject/database/Datab.db');
$taskId = str_replace('task-', '', $data['task_id']);
$newStatus = strtoupper($data['new_status']);

$stmt = $db->prepare("UPDATE tasks SET status = :status WHERE id = :id");
$stmt->bindValue(':status', $newStatus, SQLITE3_TEXT);
$stmt->bindValue(':id', $taskId, SQLITE3_INTEGER);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'DB error']);
}
?>