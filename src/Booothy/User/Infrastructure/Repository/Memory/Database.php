<?php

namespace Booothy\User\Infrastructure\Repository\Memory;

use Booothy\User\Domain\Model\User;

class Database
{
    protected $users = [];

    public function addUser(User $user)
    {
        $this->users[$user->email()->value()] = $user;
    }
}