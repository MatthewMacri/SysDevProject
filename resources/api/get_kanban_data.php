<?php
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';
$app = require_once dirname(__DIR__, 2) . '/bootstrap/app.php';

require_once app_path('Http/Controllers/core/databaseController.php');

use App\Http\Controllers\core\DatabaseController;

// Enable full error reporting for debugging (development only)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set response content type
header('Content-Type: application/json');

// Connect to SQLite database
$database = DatabaseController::getInstance();
$db = $database->getConnection();

// Query all tasks
$result = $db->query("SELECT project_id, project_name, status FROM Project");

// Define columns for Kanban statuses
$columns = [
    'PROSPECTING' => [],
    'IN PROGRESS' => [],
    'HOLD' => [],
    'COMPLETED' => []
];

// Process result and group tasks by status
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $status = strtoupper(trim($row['status']));

    // Skip unknown statuses gracefully
    if (!array_key_exists($status, $columns)) {
        continue;
    }

    $columns[$status][] = [
        'id' => 'task-' . $row['project_id'],
        'title' => $row['project_name']
    ];
}

// Return grouped tasks as JSON
echo json_encode($columns);