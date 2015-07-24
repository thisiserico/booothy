<?php

namespace Booothy\User\Domain\Model\ValueObject;

final class Id
{
    private $raw_id;

    public function __construct($a_raw_id)
    {
        $this->raw_id = $a_raw_id;
    }

    public function id()
    {
        return $this->id;
    }
}