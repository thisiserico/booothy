<?php

namespace Booothy\User\Infrastructure\Repository\Memory;

use Booothy\User\Domain\Model\User;
use Booothy\User\Domain\Model\ValueObject\Email;

class Database
{
    protected $users = [];

    public function addResource(User $user)
    {
        $this->users[$user->email()->value()] = $user;
    }

    public function getResource(Email $email)
    {
        return $this->users[$email->value()];
    }
}