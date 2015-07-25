<?php

namespace Booothy\User\Domain\Model;

final class UserCollection
{
    private $users;

    public function __construct()
    {
        $this->users = [];
    }

    public function add(User $user)
    {
        $this->users[] = $user;
    }

    public function users()
    {
        return $this->users;
    }
}