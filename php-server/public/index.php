<?php

use App\App\Application;

require __DIR__ . '/../vendor/autoload.php';

header('Content-Type: application/json');

$app = new Application();
$app->run();
