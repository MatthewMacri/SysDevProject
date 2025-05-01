<?php

require_once 'models/AdminModel.php';

class AdminController {
    private $model;

    public function __construct($db) {
        $this->model = new AdminModel($db);
    }

    public function index() {
        $admins = $this->model->getAllAdmins();
        include 'views/admin/index.php';
    }

    public function create() {
        include 'views/admin/create.php';
    }

    public function store($postData) {
        $this->model->addAdmin($postData);
        header('Location: ?controller=admin&action=index');
    }
}