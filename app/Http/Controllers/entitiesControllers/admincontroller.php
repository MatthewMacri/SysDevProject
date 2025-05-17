<?php

namespace Controllers;

require_once dirname(__DIR__, 4) . '/vendor/autoload.php';
$app = require_once dirname(__DIR__, 4) . '/bootstrap/app.php';
require_once app_path('Models/users/admin.php');
use App\Models\Admin;

class AdminController
{
    private $model;
    private $encryptionKey = 'your-secret-encryption-key'; // CHANGE THIS to a secure key

    public function __construct($db)
    {
        $this->model = new Admin($db);
    }

    public function index()
    {
        $admins = $this->model->getAllAdmins();
        if (!function_exists('resource_path')) {
            require_once dirname(__DIR__, 4) . '/vendor/autoload.php';
            $app = require_once dirname(__DIR__, 4) . '/bootstrap/app.php';
        }
        include resource_path('views/admin/listAdmins.php');
    }

    public function create()
    {
        if (!function_exists('resource_path')) {
            require_once dirname(__DIR__, 4) . '/vendor/autoload.php';
            $app = require_once dirname(__DIR__, 4) . '/bootstrap/app.php';
        }
        include resource_path('views/admin/createAdmin.php');
    }

    public function store($postData)
    {
        // Encrypt the password before storing it
        $encryptedPassword = $this->encryptPassword($postData['password']);
        $postData['password'] = $encryptedPassword;

        // Now pass the encrypted password to the model to store in the database
        $this->model->addAdmin($postData);
        header('Location: ?controller=admin&action=index');
    }

    public function edit($id)
    {
        $admin = $this->model->getAdminById($id);
        if (!function_exists('resource_path')) {
            require_once dirname(__DIR__, 4) . '/vendor/autoload.php';
            $app = require_once dirname(__DIR__, 4) . '/bootstrap/app.php';
        }
        include resource_path('views/admin/editAdmin.php');
    }

    public function update($id, $postData)
    {
        // Encrypt the password before updating
        if (isset($postData['password'])) {
            $encryptedPassword = $this->encryptPassword($postData['password']);
            $postData['password'] = $encryptedPassword;
        }

        $this->model->updateAdmin($id, $postData);
        header('Location: ?controller=admin&action=index');
    }

    public function delete($id)
    {
        $this->model->deleteAdmin($id);
        header('Location: ?controller=admin&action=index');
    }

    // Method to encrypt the password
    private function encryptPassword($password)
    {
        // Encrypt the password using openssl
        return openssl_encrypt($password, 'AES-128-ECB', $this->encryptionKey);
    }

    // Method to decrypt the password (for verification during login)
    public function decryptPassword($encryptedPassword)
    {
        return openssl_decrypt($encryptedPassword, 'AES-128-ECB', $this->encryptionKey);
    }
}