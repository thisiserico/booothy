<?php

namespace Booothy\User\Domain\Model;

use Booothy\User\Domain\Model\ValueObject\Email;

final class User
{
    private $email;

    public function __construct(Email $an_email)
    {
        $this->email = $an_email;
    }

    public function email()
    {
        return $this->email;
    }
}