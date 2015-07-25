<?php

ini_set('display_errors', 0);

use Silex\Provider\MonologServiceProvider;

define('ENV', 'prod');

require_once BASE_DIR . 'vendor/autoload.php';

$app = require __DIR__.'/../Application.php';

$app->register(new MonologServiceProvider, [
    'monolog.logfile' => $app['container']->getParameter('folder.logs') . 'silex.log',
]);

$app['twig.path']    = [__DIR__.'/../../../Templates'];
$app['twig.options'] = ['cache' => $app['container']->getParameter('folder.cache') . 'twig'];

require __DIR__.'/../Controllers.php';

$app->run();