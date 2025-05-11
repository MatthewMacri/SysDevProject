<?php
namespace Controllers;

require_once 'databasecontroller.php';

use Controllers\DatabaseController;
use APP\Models\Project;
use Illuminate\Http\Request;

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

$db = DatabaseController::getInstance()->getConnection();

switch ($method) {
    case 'GET':
        ProjectController::searchProject();
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        $stmt = $db->prepare("INSERT INTO project (serialNumber, title, description, status) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $data['serialNumber'],
            $data['title'],
            $data['description'],
            $data['status']
        ]);
        echo json_encode(["message" => "Project created"]);
        break;

    // Add PUT and DELETE logic here
}

class ProjectController {
    private static $db;

    public static function getDB() {
        if(self::$db === null) {
            self::$db = DatabaseController::getInstance()->getConnection();
        }
        return self::$db;
    }
    public static function searchProject(Request $request) {
        // Pass form inputs to model
        $projects = Project::searchWithFilters($request->all());

        // Render Blade view
        return view('project.search', compact('projects'));
    }

}