<?php

namespace Booothy\User\Application\Marshaller;

use Booothy\Core\Application\Marshaller;

final class Collection implements Marshaller
{
    private $resource_marshaller;

    public function __construct(Resource $a_resource_marshaller)
    {
        $this->resource_marshaller = $a_resource_marshaller;
    }

    public function __invoke($elements)
    {
        return array_map([$this->resource_marshaller, '__invoke'], $elements->users());
    }
}