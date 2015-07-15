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
        $mime_type     = $uploaded_file->getClientMimeType();
        $file_path     = BASE_DIR . 'var/tmp/' . $uploaded_file->getFilename();
        $uploaded_file->move(BASE_DIR . 'var/tmp', $uploaded_file->getFilename());

        $use_case = $app['container']->get(self::USE_CASE);
        $response = $use_case(new Request($quote, $mime_type, $file_path));

        return new SilexResponse($response);
    }
}