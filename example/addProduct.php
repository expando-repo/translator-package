<?php
    require_once 'boot.php';

    $translator = new \Expando\Translator\Translator();
    $translator->setToken($_SESSION['translator_token'] ?? null);
    $translator->setUrl(URL);

    if (!$translator->isLogged()) {
        die('Translator is not logged');
    }

    try {
        $product = new \Expando\Translator\Request\ProductRequest();
        $product->setProductId(rand(1000, 9999));
        $product->setTitle('Testovací title');
        $product->setDescription('Testovací popis');
        $product->setLanguageFrom(\Expando\Translator\Language::cs_CZ);
        $product->setLanguageTo(\Expando\Translator\Language::en_GB);
        //$product->setProjectId(7);
        $product->addImageUrl('https://metalshopcz.vshcdn.net/images/produkty/thumb2/metalic_003.JPG');
        $product->addImageUrl('https://metalshopcz.vshcdn.net/images/produkty/thumb2/pgg_w20_labagv_dark_grey_1_2.jpg');

        /** @var \Expando\Translator\Response\Product\GetResponse $response */
        $response = $translator->send($product);

    }
    catch (\Expando\Translator\Exceptions\TranslatorException $e) {
        die($e->getMessage());
    }

    echo 'Hash: ' . $response->getHash();
