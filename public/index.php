<?php

use App\Core\Main;

define('ROOT', dirname(__DIR__));
require ROOT . "/vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(ROOT);
$dotenv->load();

$app = new Main();
$app->start();