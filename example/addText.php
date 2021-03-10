<?php

use Expando\Translator\Type\TextType;

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
        $text = new \Expando\Translator\Request\TextRequest();
        $text->setText('První věta. Druhá věta.');
        $text->setTextType(TextType::PRODUCT_CATEGORY);
        $text->setLanguageFrom(\Expando\Translator\Type\Language::cs_CZ);
        $text->setLanguageTo(\Expando\Translator\Type\Language::en_GB);
        // $text->setProjectId(7);
        $text->setCustom('category', 124);

        /** @var \Expando\Translator\Response\Product\GetResponse $response */
        $response = $translator->send($text);

    }
    catch (\Expando\Translator\Exceptions\TranslatorException $e) {
        die($e->getMessage());
    }

    echo 'Hash: ' . $response->getHash();
