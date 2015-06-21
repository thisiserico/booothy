<?php

if (!(isset($_SERVER['APP_ENV']) && $_SERVER['APP_ENV'] == 'dev')) {
    header('HTTP/1.0 404 Not found');
    exit();
}

use Symfony\Component\Debug\Debug;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\WebProfilerServiceProvider;

define('ENV', 'dev');

require_once BASE_DIR . 'vendor/autoload.php';

Debug::enable();
$app          = require __DIR__.'/../Application.php';
$app['debug'] = true;

$app->register(new MonologServiceProvider, [
    'monolog.logfile' => BASE_DIR . 'var/logs/silex_dev.log',
]);

$app->register(new WebProfilerServiceProvider, [
    'profiler.cache_dir' => BASE_DIR . 'var/cache/profiler',
]);

require __DIR__.'/../Controllers.php';

$app->run();