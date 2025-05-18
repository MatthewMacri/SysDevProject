<?php

namespace App\Http\Controllers\supplierController;

require_once dirname(__DIR__, 4) . '/vendor/autoload.php';
$app = require_once dirname(__DIR__, 4) . '/bootstrap/app.php';

require_once app_path('Models/projectAssociatesControllers/supplier.php');
use App\Models\projectAssociatesControllers\Supplier;

class SupplierController {
    private $model;

    /**
     * Constructor that initializes the Supplier model.
     * 
     * @param object $db Database connection instance
     */
    public function __construct($db) {
        // Instantiate the Supplier model with the database connection
        $this->model = new Supplier();
    }

    /**
     * Displays a list of all suppliers.
     * 
     * Fetches all suppliers from the model and loads the view.
     * 
     * @return void
     */
    public function index() {
        // Fetch all suppliers
        $suppliers = $this->model->getAll();

        // Include the view to display the suppliers
        if (!function_exists('resource_path')) {
            require_once dirname(__DIR__, 4) . '/vendor/autoload.php';
            $app = require_once dirname(__DIR__, 4) . '/bootstrap/app.php';
        }
        include resource_path('views/supplier/listSupplier.php');
    }

    /**
     * Shows the form for creating a new supplier.
     * 
     * @return void
     */
    public function createForm() {
        // Include the supplier creation form view
        if (!function_exists('resource_path')) {
            require_once dirname(__DIR__, 4) . '/vendor/autoload.php';
            $app = require_once dirname(__DIR__, 4) . '/bootstrap/app.php';
        }
        include resource_path('views/supplier/createSupplier.php');
    }

    /**
     * Handles the creation of a new supplier.
     * 
     * @param array $postData Data from the form submission containing supplier details
     * 
     * @return void
     */
    public function store($postData) {
        // Create the new supplier using the data from the form
        $this->model->create($postData);

        // Redirect to the supplier list page after creation
        header('Location: ?controller=supplier&action=index');
    }

    /**
     * Shows the form for editing an existing supplier.
     * 
     * @param int $id The ID of the supplier to edit
     * 
     * @return void
     */
    public function edit($id) {
        // Fetch the supplier data to edit
        $supplier = $this->model->getById($id);

        // Include the edit supplier form view
        if (!function_exists('resource_path')) {
            require_once dirname(__DIR__, 4) . '/vendor/autoload.php';
            $app = require_once dirname(__DIR__, 4) . '/bootstrap/app.php';
        }
        include resource_path('views/supplier/editSupplier.php');
    }

    /**
     * Handles the update of an existing supplier's data.
     * 
     * @param int $id The ID of the supplier to update
     * @param array $postData Data from the form submission containing updated supplier details
     * 
     * @return void
     */
    public function update($id, $postData) {
        // Update the supplier using the submitted data
        $this->model->update($id, $postData);

        // Redirect to the supplier list page after update
        header('Location: ?controller=supplier&action=index');
    }

    /**
     * Deletes a supplier from the database.
     * 
     * @param int $id The ID of the supplier to delete
     * 
     * @return void
     */
    public function delete($id) {
        // Delete the supplier from the database
        $this->model->delete($id);

        // Redirect to the supplier list page after deletion
        header('Location: ?controller=supplier&action=index');
    }
}