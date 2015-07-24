<?php

namespace App\Ui\Silex\Web\Controller\Api\Photos;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request as SilexRequest;
use Symfony\Component\HttpFoundation\JsonResponse as SilexResponse;
use Booothy\Photo\Application\Service\PostResource\Request;
use Booothy\Photo\Domain\Event\NewPhotoUploaded;

final class PostResource
{
    const USE_CASE = 'photo.application.service.post_resource';

    public function __invoke(SilexRequest $silex_request, Application $app)
    {
        $quote         = $silex_request->get('quote');
        $uploaded_file = $silex_request->files->get('uploaded_file');
        $mime_type     = $uploaded_file->getClientMimeType();
        $file_path     = $app['container']->getParameter('folder.tmp') . $uploaded_file->getFilename();
        $uploaded_file->move($app['container']->getParameter('folder.tmp'), $uploaded_file->getFilename());

        $app['container']
            ->get('app.event.emitter')
            ->addListener(
                NewPhotoUploaded::class,
                $app['container']->get('photo.application.listener.compute_image_details')
            );

        $app['container']
            ->get('app.event.emitter')
            ->addListener(
                NewPhotoUploaded::class,
                $app['container']->get('photo.application.listener.generate_uploads')
            );

        $use_case = $app['container']->get(self::USE_CASE);
        $response = $use_case(new Request($quote, $mime_type, $file_path));

        return new SilexResponse($response);
    }
}