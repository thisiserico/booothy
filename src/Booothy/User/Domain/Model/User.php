<?php

namespace Booothy\Photo\Domain\Model;

use Booothy\Photo\Domain\Model\ValueObject\Id;
use Booothy\Photo\Domain\Model\ValueObject\Email;

final class Photo
{
    private $id;
    private $email;

    public function __construct(Id $an_id, Email $an_email)
    {
        $this->id    = $an_id;
        $this->email = $an_email;
    }

    public function id()
    {
        return $this->id;
    }

    public function email()
    {
        return $this->email;
    }
}