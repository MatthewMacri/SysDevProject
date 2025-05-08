<?php
require_once 'app/Models/database.php';
use App\Models\Database;

$db = new Database();

$controller = $_GET['controller'] ?? 'home';
$action = $_GET['action'] ?? 'index';

switch ($controller) {
    case 'admin':
        require_once 'app/Http/Controllers/adminController/admincontroller.php';
        $obj = new AdminController($db->connect());
        break;
    case 'supplier':
        require_once 'app/Http/Controllers/supplierController/suppliercontroller.php';
        $obj = new SupplierController($db->connect());
        break;
    case 'photo':
        require_once 'app/Http/Controllers/photoController/photocontroller.php';
        $obj = new PhotoController($db->connect());
        break;
    case 'home':
        header('Location: views/home.html');
        exit;
    default:
        die("Invalid controller.");
}

// Run the appropriate action
if (method_exists($obj, $action)) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $obj->$action($_POST);
    } elseif (isset($_GET['id'])) {
        $obj->$action($_GET['id']);
    } else {
        $obj->$action();
    }
} else {
    die("Action not found.");
}