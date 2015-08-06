<?php

namespace Booothy\User\Infrastructure\Repository\Memory;

use Booothy\User\Domain\Model\User;
use Booothy\User\Domain\Model\ValueObject\Email;
use Booothy\User\Domain\Repository\Exception\NonExistingResource;

class Database
{
    protected $users = [];

    public function addResource(User $user)
    {
        $this->users[$user->email()->value()] = $user;
    }

    public function getFirst()
    {
        if (empty($this->users)) {
            return null;
        }

        return $this->users[key($this->users)];
    }

    public function getResource(Email $email)
    {
        $user_id = $email->value();

        if (!array_key_exists($user_id, $this->users)) {
            throw new NonExistingResource;
        }

        return $this->users[$user_id];
    }

    public function getCollection()
    {
        return array_values($this->users);
    }
}