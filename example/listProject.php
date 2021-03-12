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
    $response = $translator->listProjects();
}
catch (\Expando\Translator\Exceptions\TranslatorException $e) {
    die($e->getMessage());
}

echo 'Status: ' . $response->getStatus() . '<br />';
foreach ($response->getProjects() as $project) {
    echo 'Project '.$project->getId().': ' . $project->getName() . ' (level: ' . $project->getLevel() . ($project->isDefault() ? ', default' : '') . ')<br />';
}