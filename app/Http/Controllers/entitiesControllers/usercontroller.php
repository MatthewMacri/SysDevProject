<?php

namespace Controllers;

use App\Models\ApplicationUser;

require_once 'app/Models/users/ApplicationUser.php';

class Usercontroller {

    private $model;

    /**
     * Constructor to initialize the ApplicationUser model.
     * 
     * @param object $db Database connection instance
     */
    public function __construct($db) {
        $this->model = new ApplicationUser($db);
    }

    /**
     * Displays the change password form.
     * 
     * @return void
     */
    public function changePasswordForm() {
        include 'resources/views/user/changePassword.php';
    }

    /**
     * Handles the change of the user's password.
     * 
     * @param array $postData Data from the password change form (oldPassword, newPassword, confirmPassword)
     * 
     * @return void
     */
    public function changePassword($postData) {
        // Start the session if not already started
        if(session_status() == PHP_SESSION_NONE) { 
            session_start();
        }

        // Check if the username exists in the session
        if (!isset($_SESSION['username'])) {
            echo "Error: username not found in session.";
            return;
        }

        // Get the username from the session
        $username = $_SESSION['username'];

        // Get the database connection
        $pdo = $this->model->getDb()->getConnection();

        // Retrieve the user from the database by username
        $user = ApplicationUser::selectByUsername($pdo, $username);

        // If no user found, return error
        if (!$user) {
            echo "Username not found.";
            return;
        }

        // Verify if the old password matches the stored password
        if (!password_verify($postData['oldPassword'], $user->getPassword())) {
            echo "Old password is incorrect.";
            return;
        }

        // Check if the new password and the confirm password match
        if ($postData['newPassword'] !== $postData['confirmPassword']) {
            echo "New passwords do not match.";
            return;
        }

        // Set the new password after hashing it
        $user->setPassword(password_hash($postData['newPassword'], PASSWORD_DEFAULT));

        // Update the user's password in the database
        $user->update($user->getUserID());

        // Return success message
        echo "Password successfully changed.";
    }

}