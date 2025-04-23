<?php

require_once 'app/Models/supplier.php';

class SupplierController {
    private $model;

    public function __construct($db) {
        $this->model = new \App\Models\Supplier($db);
    }

    public function index() {
        $suppliers = $this->model->getAll();
        include 'resources/views/listSuppliers.php';
    }

    public function createForm() {
        include 'resources/views/createSupplier.php';
    }

    public function store($postData) {
        $this->model->create($postData);
        header('Location: ?controller=supplier&action=index');
    }
}
