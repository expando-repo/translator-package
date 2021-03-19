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

    if ($_POST['send'] ?? null) {
        try {
            $product = new \Expando\Translator\Request\ProductRequest();
            $product->setProductId(rand(1000, 9999));
            $product->setTitle($_POST['product_title']);
            $product->setDescription($_POST['product_description']);
            $product->setDescription2($_POST['product_description2'] ?? null);
            $product->setLanguageFrom(\Expando\Translator\Type\Language::cs_CZ);
            $product->setLanguageTo(\Expando\Translator\Type\Language::en_GB);
            //$product->setProjectId(7);
            $product->addImageUrl('https://metalshopcz.vshcdn.net/images/produkty/thumb2/metalic_003.JPG');
            $product->addImageUrl('https://metalshopcz.vshcdn.net/images/produkty/thumb2/pgg_w20_labagv_dark_grey_1_2.jpg');
            $product->setProductUrl('https://www.metalshop.cz/p/113238-cepice-detska-son-of-odin-in-white-black-metal-kids-351-15-8-7/');

            /** @var \Expando\Translator\Response\Product\GetResponse $response */
            $response = $translator->send($product);

        }
        catch (\Expando\Translator\Exceptions\TranslatorException $e) {
            die($e->getMessage());
        }

        echo 'Hash: ' . $response->getHash().'<br /><br />';
    }
?>

<form method="post">
    <div>
        <label>
            Product title<br />
            <input type="text" name="product_title" value=""  />
        </label>
    </div>
    <div>
        <label>
            Product description<br />
            <textarea name="product_description"></textarea>
        </label>
    </div>
    <div>
        <label>
            Product description2<br />
            <textarea name="product_description2"></textarea>
        </label>
    </div>
    <div>
        <input type="submit" name="send" value="send" />
    </div>
</form>
