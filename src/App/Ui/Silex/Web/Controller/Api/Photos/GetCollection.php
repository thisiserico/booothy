<?php

namespace App\Ui\Silex\Web\Controller\Api\Photos;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request as SilexRequest;
use Symfony\Component\HttpFoundation\JsonResponse as SilexResponse;
use Booothy\Photo\Application\Service\GetCompleteCollection\Request;

final class GetCollection
{
    const PHOTOS_PER_PAGE = 30;
    const USE_CASE        = 'photo.application.service.get_complete_collection';

    public function __invoke(SilexRequest $silex_request, Application $app)
    {
        $use_case = $app['container']->get(self::USE_CASE);
        $response = $use_case(new Request(
            (int) $silex_request->get('page', 1),
            self::PHOTOS_PER_PAGE
        ));

        return new SilexResponse($response);
    }
}