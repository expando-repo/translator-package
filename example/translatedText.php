<?php
    require_once 'boot.php';

    $translator = new \Expando\Translator\Translator();
    $translator->setToken($_SESSION['translator_token'] ?? null);
    $translator->setUrl(URL);

    if (!$translator->isLogged()) {
        die('Translator is not logged');
    }

    try {
        // return 10 not commited products
        $response = $translator->listTranslatedTexts();
        foreach ($response->getTexts() as $text) {

            // SAVE TEXT implement

            // confirm saving text
            $translator->commitText($text);
        }
    }
    catch (\Expando\Translator\Exceptions\TranslatorException $e) {
        die($e->getMessage());
    }

    echo 'Status: ' . $response->getStatus() . '<br />';
    foreach ($response->getTexts() as $text) {
        echo '<br />';
        echo 'Hash: ' . $text->getHash() . '<br />';
        echo 'Custom id: ' . $text->getCustomId() . '<br />';
        echo 'Custom name: ' . $text->getCustomName() . '<br />';
        echo 'Text: ' . $text->getText() . '<br />';
        echo 'Language: ' . $text->getLanguage() . '<br />';
    }

