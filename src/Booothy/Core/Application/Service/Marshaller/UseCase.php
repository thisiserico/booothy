<?php

namespace Booothy\Core\Application\Service\Marshaller;

use Booothy\Core\Application\Marshaller;
use Booothy\Core\Application\Request;
use Booothy\Core\Application\Service;

final class UseCase implements Service
{
    private $dependant_service;
    private $marshaller;

    public function __construct(
        Service $a_dependant_service,
        Marshaller $a_marshaller
    ) {
        $this->dependant_service = $a_dependant_service;
        $this->marshaller = $a_marshaller;
    }

    public function __invoke(Request $request)
    {
        $raw_result = $this->dependant_service->__invoke($request);
        return $this->marshaller->__invoke($raw_result);
    }
}
