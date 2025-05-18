<?php

use App\Http\Controllers\core\AuthController;

// Call the controller that contains sendResetLink()
require_once __DIR__ . '../../../app/Http/Controllers/core/authController.php';

// Instantiate and execute the method
$auth = new AuthController();
$auth->sendResetLink();
