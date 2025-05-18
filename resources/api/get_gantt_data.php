<?php
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';
$app = require_once dirname(__DIR__, 2) . '/bootstrap/app.php';

require_once app_path('Http/Controllers/core/databaseController.php');

use App\Http\Controllers\core\DatabaseController;
// Return JSON response
header('Content-Type: application/json');

try {
    // Connect to SQLite database with PDO
    $database = DatabaseController::getInstance();
    $db = $database->getConnection();
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