<?php require_once __DIR__ . '/vendor/autoload.php';

define('ROOT_PATH', __DIR__);

use SimpleMVC\App;

$app = new App();

$app->run();