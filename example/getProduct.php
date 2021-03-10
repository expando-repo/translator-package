<?php
    require_once 'boot.php';

    $translator = new \Expando\Translator\Translator();
    $translator->setToken($_SESSION['translator_token'] ?? null);
    $translator->setUrl(URL);
    if ($translator->isTokenExpired()) {
        $translator->refreshToken(CLIENT_ID, CLIENT_SECRET);
        if ($translator->isLogged()) {
            $_SESSION['translator_token'] = $translator->getToken();
        }
    }

    if (!$translator->isLogged()) {
        die('Translator is not logged');
    }

    try {
        $response = $translator->getProduct($_GET['hash'] ?? null);
    }
    catch (\Expando\Translator\Exceptions\TranslatorException $e) {
        echo 'Hash: "' . ($_GET['hash'] ?? null) . '"<br />';
        die($e->getMessage());
    }

    echo 'Status: ' . $response->getStatus() . '<br />';
    echo 'Hash: ' . $response->getHash() . '<br />';
    echo 'Product ID: ' . $response->getProductId() . '<br />';
    echo 'Title: ' . $response->getTitle() . '<br />';
    echo 'Description: ' . $response->getDescription() . '<br />';
    echo 'Description2: ' . $response->getDescription2() . '<br />';
    echo 'Language: ' . $response->getLanguage() . '<br />';
