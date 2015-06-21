<?php

ini_set('display_errors', 0);

define('ENV', 'prod');

require_once BASE_DIR . 'vendor/autoload.php';

$app = require __DIR__.'/../Application.php';
require __DIR__.'/../Controllers.php';

$app->run();