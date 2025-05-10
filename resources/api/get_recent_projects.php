<?php
header('Content-Type: application/json');

try {
  $db = new PDO("sqlite:C:/xampp/htdocs/SysDevProject/database/Datab.db");
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $stmt = $db->prepare("
    SELECT project_id, serial_number, project_name, project_description, status, creation_time
    FROM PROJECT
    ORDER BY datetime(creation_time) DESC
    LIMIT 5
  ");
  $stmt->execute();
  $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

  echo json_encode($projects);
} catch (PDOException $e) {
  echo json_encode(["error" => $e->getMessage()]);
}
?>