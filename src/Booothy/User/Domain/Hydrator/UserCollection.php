<?php

namespace Booothy\User\Domain\Hydrator;

interface UserCollection
{
    public function __invoke($result_set);
}
