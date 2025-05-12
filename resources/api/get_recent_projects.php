<?php
// Set content type to JSON for API response
header('Content-Type: application/json');

try {
    // Connect to the SQLite database
    $db = new PDO("sqlite:C:/xampp/htdocs/SysDevProject/database/Datab.db");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare SQL to fetch the 5 most recent projects
    $stmt = $db->prepare("
        SELECT 
            project_id, 
            serial_number, 
            project_name, 
            project_description, 
            status, 
            creation_time
        FROM PROJECT
        ORDER BY datetime(creation_time) DESC
        LIMIT 5
    ");
    $stmt->execute();

    // Fetch and return the result as JSON
    $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($projects);

} catch (PDOException $e) {
    // Handle and return any database errors
    echo json_encode([
        "error" => $e->getMessage()
    ]);
}