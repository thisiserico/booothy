<?php

namespace Booothy\User\Domain\Repository;

use Booothy\User\Domain\Model\User;

interface ResourceSaver
{
    public function __invoke(User $user);
}