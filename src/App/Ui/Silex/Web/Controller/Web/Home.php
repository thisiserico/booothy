<?php

namespace App\Ui\Silex\Web\Controller\Web;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request as SilexRequest;
use Symfony\Component\HttpFoundation\Response as SilexResponse;

final class Home
{
    public function __invoke(SilexRequest $silex_request, Application $app)
    {
        return new SilexResponse($app['twig']->render(
            'home.tpl',
            [
                'api_url' => sprintf(
                    '%s/api/',
                    $app['container']->getParameter('booothy_url')
                ),
                'google_client_id' => $app['container']->getParameter('google.client_id'),
            ]
        ));
    }
}
