<?php

namespace Booothy\User\Domain\Hydrator;

interface UserResource
{
    public function __invoke(array $user);
}