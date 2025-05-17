<?php

namespace App\Http\Controllers\entitiesControllers;

require_once dirname(__DIR__, 4) . '/vendor/autoload.php';
$app = require_once dirname(__DIR__, 4) . '/bootstrap/app.php';

require_once app_path('Http/Controllers/core/databaseController.php');
require_once app_path('Models/project.php');

use App\Http\Controllers\core\DatabaseController;
use App\Models\Project;
use App\Models\Client;
use App\Models\Supplier;
use App\Models\Photo;
use App\Models\Video;

class ProjectController
{
    private $db;

    /**
     * Constructor to initialize the database connection.
     * Uses the singleton instance of DatabaseController to get the PDO connection.
     */
    public function __construct()
    {
        $this->db = DatabaseController::getInstance()->getConnection();
    }

    /**
     * Handles the search for projects with optional filters from the request.
     * 
     * @return void
     */
    public function search()
    {
        // Get filters from the request
        $filters = $_GET;

        // Use the Project model to search for projects with the provided filters
        $projects = Project::searchWithFilters($filters);

        // Include the view to display the search results
        if (!function_exists('resource_path')) {
            require_once dirname(__DIR__, 4) . '/vendor/autoload.php';
            $app = require_once dirname(__DIR__, 4) . '/bootstrap/app.php';
        }
        include resource_path('views/project/SearchProject.php');
    }

    /**
     * Stores a new project in the database.
     * 
     * @return void
     */
    public function store()
    {
        // Set the response content type to JSON
        header('Content-Type: application/json');

        // Read the incoming JSON data
        $data = json_decode(file_get_contents("php://input"), true);

        // Prepare the SQL query to insert a new project into the Project table
        $stmt = $this->db->prepare("
            INSERT INTO Project (serial_number, project_name, project_description, status)
            VALUES (?, ?, ?, ?)
        ");

        // Execute the query with the provided data
        $stmt->execute([
            $data['serialNumber'],
            $data['title'],
            $data['description'],
            $data['status']
        ]);

        // Send a response confirming the creation of the project
        echo json_encode(["message" => "Project created"]);
    }

    /**
     * Searches for projects based on the given filters (passed via GET parameters).
     * Returns the result in JSON format.
     * 
     * @return void
     */
    public function searchJson()
    {
        // Enable error reporting for debugging purposes
        // ini_set('display_errors', 1);
        // ini_set('display_startup_errors', 1);
        // error_reporting(E_ALL);

        // Set the response content type to JSON
        // header('Content-Type: application/json');

        // Get the filters from the request
        $filters = $_GET;

        // Use the Project model to search for projects with the provided filters
        $projects = Project::searchWithFilters($filters);

        // Return the results as a JSON response
        echo json_encode($projects);
    }

    public function formSubmission($data)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($data['confirm'])) {
            $projectTitle = $data['project-title'];
            $serialNumber = $data['project-serial-number'];
            $description = $data['project-description'];
            $startDate = $data['project-start-date'];
            $endDate = $data['project-end-date'];

            // CLIENT INFO
            $clientName = $data['client-name'];
            $clientCompany = $data['client-company'];
            $clientEmail = $data['client-email'];
            $clientPhone = $data['client-phone'];

            // SUPPLIER INFO — multiple suppliers may exist
            $supplierNames = $data['supplier-name'];
            $supplierCompanies = $data['supplier-company'];
            $supplierEmails = $data['supplier-email'];
            $supplierPhones = $data['supplier-phone'];

            $supplierDate = $data['supplier-date'] ?? null;

            // Load all Models and inject into handler
            $projectModel = new Project();
            $clientModel = new Client($clientName, $clientCompany, $clientEmail, $clientPhone);
            $supplierModel = new Supplier();

            if (!function_exists('resource_path')) {
                require_once dirname(__DIR__, 4) . '/vendor/autoload.php';
                $app = require_once dirname(__DIR__, 4) . '/bootstrap/app.php';
            }
            
            include_once resource_path('services/projectService.php');
            $service = new \Services\ProjectService(
                $projectModel,
                $clientModel,
                $supplierModel
            );

            $service->createFullProject([
                'title' => $projectTitle,
                'serial' => $serialNumber,
                'desc' => $description,
                'start' => $startDate,
                'end' => $endDate,
                'client' => [
                    'name' => $clientName,
                    'company' => $clientCompany,
                    'email' => $clientEmail,
                    'phone' => $clientPhone,
                ],
                'suppliers' => array_map(null, $supplierNames, $supplierCompanies, $supplierEmails, $supplierPhones),
                'supplier_date' => $supplierDate
            ]);
        }
        exit;
    }
}