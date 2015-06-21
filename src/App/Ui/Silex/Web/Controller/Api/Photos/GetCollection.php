<?php

namespace App\Ui\Silex\Web\Controller\Api\Photos;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request as SilexRequest;
use Symfony\Component\HttpFoundation\JsonResponse as SilexResponse;
use Booothy\Photo\Application\Service\GetCompleteCollection\Request;

final class GetCollection
{
    public function __invoke(SilexRequest $silex_request, Application $app)
    {
        $use_case = $app['container']->get('photo.application.service.get_complete_collection');
        $response = $use_case(new Request);

        return new SilexResponse($response);
    }
}