<?php

use Expando\Translator\Exceptions\LoginException;

require_once 'boot.php';

try {
    $login = new \Expando\Translator\Login(
        1,
        '4XJ27RN0uOiiTtEWvD1GpTQIGITVIKE1nEBVupha',
        'http://local.php80/translator/example/redirect.php',
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