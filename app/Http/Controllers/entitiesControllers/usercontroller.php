<?php

namespace Controllers;

use App\Models\ApplicationUser;

require_once 'app/Models/users/ApplicationUser.php';
class Usercontroller {

    private $model;
    public function __construct($db) {
        $this->model = new ApplicationUser($db);
    }

    public function changePasswordForm() {
        include 'resources/views/user/changePassword.php';
    }
    
    public function changePassword($postData) {
        if(session_status() == PHP_SESSION_NONE) { 
            session_start();
        }  
        if (!isset($_SESSION['username'])) {
            echo "error, with username";
            return;
        }
    
        $username = $_SESSION['username'];
        $pdo = $this->model->getDb()->getConnection();
        $user = ApplicationUser::selectByUsername($pdo, $username);
    
        if (!$user) {
            echo "usernmae not found";
            return;
        }
    
        if (!password_verify($postData['oldPassword'], $user->getPassword())) {
            echo "Old password is incorrect.";
            return;
        }
    
        if ($postData['newPassword'] !== $postData['confirmPassword']) {
            echo "New passwords do not match.";
            return;
        }
    
        $user->setPassword(password_hash($postData['newPassword'], PASSWORD_DEFAULT));
    
        $user->update($user->getUserID());
    
        echo "Password successfully changed.";
    }
    

}