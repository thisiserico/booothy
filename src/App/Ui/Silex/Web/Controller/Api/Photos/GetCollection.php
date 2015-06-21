<?php

namespace App\Ui\Silex\Web\Controller\Api\Photos;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request as SilexRequest;
use Symfony\Component\HttpFoundation\JsonResponse as SilexResponse;

final class GetCollection
{
    public function __invoke(SilexRequest $silex_request, Application $app)
    {
        return new SilexResponse(['status' => 'ok']);
    }
}