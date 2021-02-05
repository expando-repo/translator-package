<?php
    require_once 'boot.php';
    $translator = new \Expando\Translator\Translator();
    $translator->setToken($_SESSION['translator_token'] ?? null);
    $translator->setUrl('http://translator.local');
?>

<?php if (!$translator->isLogged()) { ?>
    <a href="redirect.php">Login (get token)</a>
<?php } else { ?>
    <ul>
        <li><a href="addProduct.php">add product</a></li>
        <li><a href="getProduct.php?hash=hash-from-url">get product</a></li>
        <li><a href="translatedProduct.php">get translated products</a></li>
        <li><a href="logout.php">logout (delete token)</a></li>
    </ul>
<?php } ?>
