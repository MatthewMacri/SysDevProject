<?php
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';
$app = require_once dirname(__DIR__,2) . '/bootstrap/app.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['lang'])) {
    $_SESSION['locale'] = $_POST['lang'];
}

$locale = $_POST['lang'] ?? 'en_US';


putenv("LC_ALL=$locale");
putenv("LANG=$locale");
putenv("LANGUAGE=$locale");

putenv("LC_ALL=$locale");
setlocale(LC_ALL, $locale);
bindtextdomain("messages", resource_path('lang/locale'));
bind_textdomain_codeset("messages", "UTF-8");
textdomain("messages");
