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


// Api
$app
    ->get('/api/photos', $controller('Api\Photos\GetCollection'))
    ->bind('api:photos:get:collection');
