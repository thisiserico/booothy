<?php

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use App\Ui\Silex\Web\Controller\Api\Users\AuthenticationHandling;

$controller = function ($controller) {
    return ''
        . 'App\Ui\Silex\Web\Controller\\'
        . $controller
        . '::__invoke';
};

$private_resources = [
    'download_thumb',
    'download',
    'api:users:get:collection',
    'api:photos:get:collection',
    'api:photos:get:resource',
    'api:photos:post:resource',
];

$app->before(function (Request $request, Application $app) use ($private_resources) {
    $authentication_handling = new AuthenticationHandling;
    return $authentication_handling($request, $app);
});


// Web
$app
    ->get('/', $controller('Web\Home'))
    ->bind('home');

$app
    ->get('/u/thumb/{filename}', function ($filename) use ($app) {
        return $app->sendFile($app['container']->getParameter('folder.uploads.thumbs') . $filename);
    })
    ->bind('download_thumb');

$app
    ->get('/u/{filename}', function ($filename) use ($app) {
        return $app->sendFile($app['container']->getParameter('folder.uploads') . $filename);
    })
    ->bind('download');


// Api
$app
    ->get('/api/users', $controller('Api\Users\GetCollection'))
    ->bind('api:users:get:collection');

$app
    ->get('/api/users/{email}', $controller('Api\Users\GetResource'))
    ->bind('api:users:get:resource');


$app
    ->get('/api/photos', $controller('Api\Photos\GetCollection'))
    ->bind('api:photos:get:collection');

$app
    ->get('/api/photos/{id}', $controller('Api\Photos\GetResource'))
    ->bind('api:photos:get:resource');

$app
    ->post('/api/photos', $controller('Api\Photos\PostResource'))
    ->bind('api:photos:post:resource');
