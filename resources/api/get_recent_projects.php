<?php
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';
$app = require_once dirname(__DIR__, 2) . '/bootstrap/app.php';

require_once app_path('Http/Controllers/core/databaseController.php');

use App\Http\Controllers\core\DatabaseController;
// Set content type to JSON for API response
header('Content-Type: application/json');

try {
    // Connect to the SQLite database
    $database = DatabaseController::getInstance();
    $db = $database->getConnection();
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