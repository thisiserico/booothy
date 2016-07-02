<?php

namespace Booothy\User\Domain\Hydrator;

use stdClass;

interface UserResource
{
    public function __invoke(stdClass $user);
}
