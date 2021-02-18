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
        $response = $translator->listTranslatedGroups();
        foreach ($response->getTexts() as $text) {

            // SAVE TEXT implement

            // confirm saving text
            $translator->commitGroup($text);
        }
    }
    catch (\Expando\Translator\Exceptions\TranslatorException $e) {
        die($e->getMessage());
    }

    echo 'Status: ' . $response->getStatus() . '<br />';
    foreach ($response->getTexts() as $group) {
        echo '<br />';
        echo 'Hash: ' . $group->getHash() . '<br />';
        echo 'Custom id: ' . $group->getCustomId() . '<br />';
        echo 'Custom name: ' . $group->getCustomName() . '<br />';
        foreach ($group->getTexts() as $key => $text) {
            echo 'Text (' . $key . '): ' . $text . '<br />';
        }
        echo 'Language: ' . $group->getLanguage() . '<br /><br />';
    }

