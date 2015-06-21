<?php

namespace Booothy\Photo\Application\Marshaller;

use Booothy\Core\Application\Marshaller;

final class Collection implements Marshaller
{
    public function __invoke($element)
    {
        return [];
    }
}