<?php

namespace App\Ui\Silex\Web\Controller\Api\Users;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request as SilexRequest;
use Symfony\Component\HttpFoundation\JsonResponse as SilexResponse;
use Booothy\User\Application\Service\GetCollection\Request;

final class GetCollection
{
    const USE_CASE = 'user.application.service.get_collection';

    public function __invoke(SilexRequest $silex_request, Application $app)
    {
        $use_case = $app['container']->get(self::USE_CASE);
        $response = $use_case(new Request);

        return new SilexResponse($response);
    }
}