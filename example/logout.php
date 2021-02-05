<?php
    require_once 'boot.php';
    unset($_SESSION['translator_token']);
    header('Location: index.php');