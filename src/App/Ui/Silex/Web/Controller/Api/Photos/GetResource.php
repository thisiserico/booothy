<?php

namespace App\Ui\Silex\Web\Controller\Api\Photos;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request as SilexRequest;
use Symfony\Component\HttpFoundation\JsonResponse as SilexResponse;
use Booothy\Photo\Application\Service\GetResource\Request;
use Booothy\Photo\Domain\Repository\Exception\NonExistingResource;

final class GetResource
{
    const USE_CASE = 'photo.application.service.get_resource';

    public function __invoke(SilexRequest $silex_request, Application $app)
    {
        $use_case = $app['container']->get(self::USE_CASE);
        $request  = new Request($silex_request->get('id'));
        $response = $this->getResponse($use_case, $request);

        return new SilexResponse($response['content'], $response['status']);
    }

    private function getResponse($use_case, $request)
    {
        try {
            return [
                'content' => $use_case($request),
                'status'  => 200,
            ];
        } catch (NonExistingResource $e) {
            return [
                'content' => ['error' => 'Non existing boooth ' . $request->id],
                'status'  => 404,
            ];
        }
    }
}