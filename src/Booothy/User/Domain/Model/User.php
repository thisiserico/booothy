<?php

namespace Booothy\User\Domain\Model;

use Booothy\User\Domain\Model\ValueObject\Email;

final class User
{
    const AVATAR_PATTERN = 'http://www.gravatar.com/avatar/';

    private $email;

    public function __construct(Email $an_email)
    {
        $this->email = $an_email;
    }

    public function email()
    {
        return $this->email;
    }

    public function avatar()
    {
        return self::AVATAR_PATTERN . md5($this->email->value());
    }
}