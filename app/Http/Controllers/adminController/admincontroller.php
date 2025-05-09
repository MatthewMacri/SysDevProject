<?php

require_once 'app/Models/adminModel/admin.php';
use App\Models\Admin;

class AdminController {
    private $model;

    public function __construct($db) {
        $this->model = new Admin($db);
    }

    public function index() {
        $admins = $this->model->getAllAdmins();
        include 'resources/views/admin/listAdmins.php';
    }

    public function create() {
        include 'resources/views/admin/createAdmin.php';
    }

    public function store($postData) {
        $this->model->addAdmin($postData);
        header('Location: ?controller=admin&action=index');
    }

    public function edit($id) {
        $admin = $this->model->getAdminById($id);
        include 'resources/views/admin/editAdmin.php';
    }
    
    public function update($id, $postData) {
        $this->model->updateAdmin($id, $postData);
        header('Location: ?controller=admin&action=index');
    }
    
    public function delete($id) {
        $this->model->deleteAdmin($id);
        header('Location: ?controller=admin&action=index');
    }    
}