<?php

namespace App\Ui\Silex\Web\Controller\Api\Users;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request as SilexRequest;
use Symfony\Component\HttpFoundation\JsonResponse as SilexResponse;
use Booothy\User\Application\Service\GetResource\Request;
use Booothy\User\Domain\Repository\Exception\NonExistingResource;

final class GetResource
{
    const USE_CASE = 'user.application.service.get_resource';

    public function __invoke(SilexRequest $silex_request, Application $app)
    {
        $use_case = $app['container']->get(self::USE_CASE);
        $request  = new Request($silex_request->get('email'));
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
                'content' => ['error' => 'Non existing user ' . $request->email],
                'status'  => 404,
            ];
        }
    }
}