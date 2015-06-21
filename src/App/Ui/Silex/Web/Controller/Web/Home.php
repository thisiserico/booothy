<?php

namespace App\Ui\Silex\Web\Controller\Web;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request as SilexRequest;
use Symfony\Component\HttpFoundation\Response as SilexResponse;

final class Home
{
    public function __invoke(SilexRequest $silex_request, Application $app)
    {
        return new SilexResponse($app['twig']->render('home.tpl', []));
    }
}