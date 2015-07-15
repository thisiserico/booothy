<?php

namespace App\Ui\Silex\Web\Controller\Api\Photos;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request as SilexRequest;
use Symfony\Component\HttpFoundation\JsonResponse as SilexResponse;
use Booothy\Photo\Application\Service\PostResource\Request;

final class PostResource
{
    const USE_CASE = 'photo.application.service.post_resource';

    public function __invoke(SilexRequest $silex_request, Application $app)
    {
        $quote         = $silex_request->get('quote');
        $uploaded_file = $silex_request->files->get('uploaded_file');

        $use_case = $app['container']->get(self::USE_CASE);
        $response = $use_case(new Request(
            $quote,
            $uploaded_file->getClientMimeType(),
            $uploaded_file->getRealPath()
        ));

        return new SilexResponse($response);
    }
}