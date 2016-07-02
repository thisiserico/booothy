<?php

use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\RoutingServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;

$app = new Application;
$app->register(new RoutingServiceProvider);
$app->register(new ValidatorServiceProvider);
$app->register(new ServiceControllerServiceProvider);
$app->register(new TwigServiceProvider);
$app->register(new HttpFragmentServiceProvider);

$file_name = 'definition.php';
$file_path = BASE_DIR . 'src/App/DependencyInjection/Services/' . $file_name;

if (!file_exists($file_path)) {
    return $app;
}

require_once $file_path;

$app['container'] = new ServiceContainer;

return $app;
