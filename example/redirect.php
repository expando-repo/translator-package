<?php

use Expando\Translator\Exceptions\LoginException;

require_once 'boot.php';

try {
    $login = new \Expando\Translator\Login(
        14,
        'KacdritiVE3fO9GsIgam6PCCMbXtAfJV5fsYYgcl',
        'http://translator-package.local/redirect.php',
        'http://translator.local'
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