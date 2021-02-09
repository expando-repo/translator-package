<?php

use Expando\Translator\Exceptions\LoginException;

require_once 'boot.php';

try {
    $login = new \Expando\Translator\Login(
        1,
        'Fqar1f95sfHKTzF5zFFQwzBm0ZNeGajBEUG6tcx7',
        'http://translator-package.local/redirect.php',
        URL
    );
    $login->addScope('read-translation');
    $login->addScope('create-translation');
    $token = $login->getToken();
} catch (LoginException $e) {
    die($e->getMessage());
}

if ($token !== null)
{
    // save to session for example
    $_SESSION['translator_token'] = $token;
    header('Location: index.php');
}