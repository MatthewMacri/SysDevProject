<?php

require_once 'app/Models/supplierModel/supplier.php';
use App\Models\Supplier;

class SupplierController {
    private $model;

    public function __construct($db) {
        $this->model = new Supplier($db);
    }

    public function index() {
        $suppliers = $this->model->getAll();
        include 'resources/views/supplier/listSupplier.php';
    }

    public function createForm() {
        include 'resources/views/supplier/createSupplier.php';
    }

    public function store($postData) {
        $this->model->create($postData);
        header('Location: ?controller=supplier&action=index');
    }

    public function edit($id) {
        $supplier = $this->model->getById($id);
        include 'resources/views/supplier/editSupplier.php';
    }

    public function update($id, $postData) {
        $this->model->update($id, $postData);
        header('Location: ?controller=supplier&action=index');
    }

    public function delete($id) {
        $this->model->delete($id);
        header('Location: ?controller=supplier&action=index');
    }
}