<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['lang'])) {
    $_SESSION['locale'] = $_POST['lang'];
}

$locale = $_SESSION['locale'] ?? 'en_US';

putenv("LC_ALL=$locale");
setlocale(LC_ALL, $locale);
bindtextdomain("messages", dirname(__DIR__, 1) . '/lang/locale');
file_put_contents("debug.txt", dirname(__DIR__, 1) . '/lang/locale', FILE_APPEND);
bind_textdomain_codeset("messages", "UTF-8");
textdomain("messages");
