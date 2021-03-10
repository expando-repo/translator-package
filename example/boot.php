<?php
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    session_start();

    //define('URL', 'http://translator.popshop.cz');
    define('URL', 'http://translator.local');
    define('CLIENT_ID', 1);
    define('CLIENT_SECRET', 'TW6R5c65r9o8LVi3XIZaJIhpPeaHxAzymfeIy6yK');


    require_once __DIR__ . '/../vendor/autoload.php';