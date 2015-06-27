<?php

$controller = function ($controller) {
    return ''
        . 'App\Ui\Silex\Web\Controller\\'
        . $controller
        . '::__invoke';
};

// Web
$app
    ->get('/', $controller('Web\Home'))
    ->bind('home');

$app
    ->get('/u/{filename}', function ($filename) use ($app) {
        return $app->sendFile(BASE_DIR . 'var/uploads/axolot.png');
    })
    ->bind('download');


// Api
$app
    ->get('/api/photos', $controller('Api\Photos\GetCollection'))
    ->bind('api:photos:get:collection');
