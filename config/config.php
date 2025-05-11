<?php
// Load environment variables (if using something like vlucas/phpdotenv)
require_once $_SERVER['DOCUMENT_ROOT'] . '/SysDevProject/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT'] . '/SysDevProject');
$dotenv->load();

// Define useful constants
define('BASE_PATH', $_SERVER['DOCUMENT_ROOT'] . '/SysDevProject');