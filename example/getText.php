<?php
    require_once 'boot.php';

    $translator = new \Expando\Translator\Translator();
    $translator->setToken($_SESSION['translator_token'] ?? null);
    $translator->setUrl(URL);

    if (!$translator->isLogged()) {
        die('Translator is not logged');
    }

    try {
        $response = $translator->getText($_GET['hash'] ?? null);
    }
    catch (\Expando\Translator\Exceptions\TranslatorException $e) {
        echo 'Hash: "' . ($_GET['hash'] ?? null) . '"<br />';
        die($e->getMessage());
    }

    echo 'Status: ' . $response->getStatus() . '<br />';
    echo 'Hash: ' . $response->getHash() . '<br />';
    echo 'Custom id: ' . $response->getCustomId() . '<br />';
    echo 'Custom name: ' . $response->getCustomName() . '<br />';
    echo 'Text: ' . $response->getText() . '<br />';
    echo 'Language: ' . $response->getLanguage() . '<br />';
