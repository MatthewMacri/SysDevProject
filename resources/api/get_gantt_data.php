<?php
header('Content-Type: application/json');

try {
$dbPath = "C:/xampp/htdocs/SysDevProject/database/Datab.db";

  // DEBUG LINE — shows the real path being used
  if (!file_exists($dbPath)) {
    echo json_encode(["error" => "Database not found at: " . $dbPath]);
    exit;
  }

  $db = new PDO("sqlite:" . $dbPath);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $stmt = $db->prepare("
    SELECT 
      project_id AS id,
      project_name AS title,
      start_date AS start,
      end_date AS end,
      0 AS parentId
    FROM PROJECT
  ");
  $stmt->execute();
  $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

  echo json_encode([
    "tasks" => $tasks,
    "dependencies" => []
  ]);
} catch (PDOException $e) {
  echo json_encode(["error" => $e->getMessage()]);
}
?>