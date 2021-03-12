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
?>

<?php if (!$translator->isLogged()) { ?>
    <a href="redirect.php">Login (get token)</a>
<?php } else { ?>
    <ul>
        <li><a href="addProduct.php">add product</a></li>
        <li><a href="getProduct.php?hash=hash-from-url">get product</a></li>
        <li><a href="translatedProduct.php">get translated products</a></li>
        <li></li>
        <li><a href="addText.php">add text</a></li>
        <li><a href="getText.php?hash=hash-from-url">get text</a></li>
        <li><a href="translatedText.php">get translated texts</a></li>
        <li></li>
        <li><a href="addSkipText.php">add skip text</a></li>
        <li></li>
        <li><a href="addGroup.php">add group text</a></li>
        <li><a href="getGroup.php?hash=hash-from-url">get group text</a></li>
        <li><a href="translatedGroup.php">get translated groups</a></li>
        <li></li>
        <li><a href="listProject.php">list project</a></li>
        <li></li>
        <li><a href="logout.php">logout (delete token)</a></li>
    </ul>
<?php } ?>
