<?php
    require_once 'boot.php';

    $translator = new \Expando\Translator\Translator();
    $translator->setToken($_SESSION['translator_token'] ?? null);
    $translator->setUrl(URL);

    if (!$translator->isLogged()) {
        die('Translator is not logged');
    }

    try {
        $group = new \Expando\Translator\Request\GroupRequest();
        $group->setTextType(\Expando\Translator\Type\TextType::PRODUCT_PARAMETER);
        $group->addText('key1', 'Černá');
        $group->addText('key2', 'Oranžová');
        $group->setLanguageFrom(\Expando\Translator\Type\Language::cs_CZ);
        $group->setLanguageTo(\Expando\Translator\Type\Language::en_GB);
        $response = $translator->send($group);

    }
    catch (\Expando\Translator\Exceptions\TranslatorException $e) {
        die($e->getMessage());
    }

    echo 'Hash: ' . $response->getHash();
