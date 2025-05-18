<?php
// Load the database class and required controller namespaces
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';

require_once app_path('\Http\Controllers\core\DatabaseController.php');

use App\Http\Controllers\core\DatabaseController;
use App\Http\Controllers\entitiesControllers\AdminController;
use App\Http\Controllers\supplierController\SupplierController;
use App\Http\Controllers\mediaControllers\PhotoController;

// Create a new database instance
$db = DatabaseController::getInstance();

if (!isset($_GET['controller'])) {
    header('Location: resources/views/login/loginview.php');
    exit;
}

// Get controller and action from the URL parameters
$controller = $_GET['controller'];
$action = $_GET['action'] ?? 'index'; // If no action is given, use 'index' as default

echo "Routing to controller: $controller, action: $action";
// Load the correct controller based on the URL
switch ($controller) {
    case 'project':
        require_once 'app/Http/Controllers/entitiesControllers/projectcontroller.php';
        $obj = new \App\Http\Controllers\entitiesControllers\ProjectController();
        break;

    case 'admin':
        require_once 'app/Http/Controllers/entitiesControllers/admincontroller.php';
        $obj = new AdminController($db->getConnection()); // Pass database connection to admin controller
        break;

    case 'supplier':
        require_once 'app/Http/Controllers/supplierController/suppliercontroller.php';
        $obj = new SupplierController($db->getConnection()); // Pass database connection to supplier controller
        break;

    case 'photo':
        require_once 'app/Http/Controllers/mediaController/photocontroller.php';
        $obj = new PhotoController($db->getConnection()); // Pass database connection to photo controller
        break;

    case 'home':
        // If "home" controller is requested, just redirect to a static homepage
        header('Location: views/home.html');
        exit;

    default:
        // Handle unknown controller names
        die("Invalid controller.");
}

// Run the requested method (action) on the controller object
if (method_exists($obj, $action)) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // If it's a POST request, pass POST data to the method
        $obj->$action($_POST);
        exit;
    } elseif (isset($_GET['id'])) {
        // If an ID is provided in the URL, pass it as a parameter
        $obj->$action($_GET['id']);
        exit;
    } else {
        // Otherwise, call the method with no parameters
        $obj->$action();
        exit;
    }
} else {
    // If the method doesn't exist in the controller
    die("Action not found.");
}