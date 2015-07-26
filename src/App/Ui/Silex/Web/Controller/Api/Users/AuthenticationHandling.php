<?php

namespace App\Ui\Silex\Web\Controller\Api\Users;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request as SilexRequest;
use Symfony\Component\HttpFoundation\JsonResponse as SilexResponse;
use Booothy\User\Application\Service\Authenticate\Exception\DisallowedUser;
use Booothy\User\Application\Service\Authenticate\Request as AuthenticationRequest;

final class AuthenticationHandling
{
    const USE_CASE = 'user.application.service.authenticate';

    public function __invoke(SilexRequest $silex_request, Application $app)
    {
        $route_name = $silex_request->attributes->get('_route');

        if (!in_array($route_name, $this->getPrivateResources())) return;

        try {
            $this->addUserToRequest($silex_request, $app);
        } catch(DisallowedUser $e) {
            return new SilexResponse(['message' => 'Disallowed user'], 403);
        }
    }

    private function getPrivateResources()
    {
        return [
            'download_thumb',
            'download',
            'api:users:get:collection',
            'api:photos:get:collection',
            'api:photos:get:resource',
            'api:photos:post:resource',
        ];
    }

    private function addUserToRequest(SilexRequest $silex_request, Application $app)
    {
        $id_token = $silex_request->get('id_token', null);

        if (!$id_token) {
            throw new DisallowedUser;
        }

        $authenticate_use_case = $app['container']->get(self::USE_CASE);
        $authenticate_request  = new AuthenticationRequest($id_token);

        $silex_request->request->set(
            'user',
            $authenticate_use_case($authenticate_request)
        );
    }
}