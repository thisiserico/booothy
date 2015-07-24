<?php

namespace Booothy\User\Domain\Model\ValueObject;

final class Email
{
    private $email;

    public function __construct($a_raw_email)
    {
        $this->email = $a_raw_email;
    }

    public function email()
    {
        return $this->email;
    }
}