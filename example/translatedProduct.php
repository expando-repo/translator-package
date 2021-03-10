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
        // return 10 not commited products
        $response = $translator->listTranslatedProducts();
        foreach ($response->getProducts() as $product) {

            // SAVE TEXT implement

            // confirm saving text
            $translator->commitProduct($product);
        }
    }
    catch (\Expando\Translator\Exceptions\TranslatorException $e) {
        die($e->getMessage());
    }

    echo 'Status: ' . $response->getStatus() . '<br />';
    foreach ($response->getProducts() as $product) {
        echo '<br />';
        echo 'Hash: ' . $product->getHash() . '<br />';
        echo 'Product ID: ' . $product->getProductId() . '<br />';
        echo 'Title: ' . $product->getTitle() . '<br />';
        echo 'Description: ' . $product->getDescription() . '<br />';
        echo 'Description2: ' . $product->getDescription2() . '<br />';
        echo 'Language: ' . $product->getLanguage() . '<br />';
    }

