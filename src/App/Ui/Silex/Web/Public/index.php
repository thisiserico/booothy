<?php

use Dotenv\Dotenv;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\WebProfilerServiceProvider;
use Symfony\Component\Debug\Debug;

require_once BASE_DIR . 'vendor/autoload.php';

$dotenv = new Dotenv(__DIR__ . '/../../../../../../');
$dotenv->load();

$environment = getenv('ENVIRONMENT');
$runningInDev = $environment == 'dev';

ini_set('display_errors', $runningInDev);
define('ENVIRONMENT', $environment);

$app = require __DIR__.'/../Application.php';

if ($runningInDev) {
    Debug::enable();
    $app['debug'] = true;

    $app->register(new WebProfilerServiceProvider, [
        'profiler.cache_dir' => $app['container']->getParameter('folder.cache') . 'profiler',
    ]);
}

$app->register(new MonologServiceProvider, [
    'monolog.logfile' => $app['container']->getParameter('folder.logs') . 'silex.log',
]);

$app['twig.path'] = [__DIR__.'/../../../Templates'];
$app['twig.options'] = ['cache' => $app['container']->getParameter('folder.cache') . 'twig'];

require __DIR__.'/../Controllers.php';

$app->run();
