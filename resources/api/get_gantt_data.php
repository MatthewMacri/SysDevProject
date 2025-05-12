<?php
// Return JSON response
header('Content-Type: application/json');

try {
    // Path to SQLite database
    $dbPath = "C:/xampp/htdocs/SysDevProject/database/Datab.db";

    // Debug safeguard: ensure DB file exists
    if (!file_exists($dbPath)) {
        echo json_encode(["error" => "Database not found at: " . $dbPath]);
        exit;
    }

    // Connect to SQLite database with PDO
    $db = new PDO("sqlite:" . $dbPath);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch project tasks for Gantt visualization
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

    // Return JSON structure compatible with Gantt libraries
    echo json_encode([
        "tasks" => $tasks,
        "dependencies" => []  // Placeholder for future dependency logic
    ]);
    
} catch (PDOException $e) {
    // Handle DB exceptions gracefully
    echo json_encode(["error" => $e->getMessage()]);
}