<?php
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    session_start();

    define('URL', 'http://translator.local');

    require_once __DIR__ . '/../vendor/autoload.php';