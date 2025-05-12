<?php
namespace App\Http\Controllers\entitiesControllers;

require_once dirname(__DIR__) . '/core/databasecontroller.php';

use Controllers\DatabaseController;
use App\Models\Project;

class ProjectController
{
    private $db;

    public function __construct()
    {
        $this->db = DatabaseController::getInstance()->getConnection();
    }

    public function search()
    {
        $filters = $_GET;
        $projects = Project::searchWithFilters($filters);

        include $_SERVER['DOCUMENT_ROOT'] . '/SysDevProject/resources/views/project/SearchProject.php';
    }

    public function store()
    {
        header('Content-Type: application/json');

        $data = json_decode(file_get_contents("php://input"), true);

        $stmt = $this->db->prepare("
            INSERT INTO Project (serial_number, project_name, project_description, status)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['serialNumber'],
            $data['title'],
            $data['description'],
            $data['status']
        ]);

        echo json_encode(["message" => "Project created"]);
    }

    public function searchJson()
{
    // header('Content-Type: application/json');
    // $filters = $_GET;
    // $projects = Project::searchWithFilters($filters);
    // echo json_encode($projects);

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    header('Content-Type: application/json');

    $filters = $_GET;
    $projects = Project::searchWithFilters($filters);
    echo json_encode($projects);
}
}