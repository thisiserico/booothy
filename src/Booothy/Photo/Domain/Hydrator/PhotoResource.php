<?php

namespace Booothy\Photo\Domain\Hydrator;

use stdClass;

interface PhotoResource
{
    public function __invoke(stdClass $photo);
}
