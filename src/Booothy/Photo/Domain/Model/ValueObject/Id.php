<?php

namespace Booothy\Photo\Domain\Model\ValueObject;

use Rhumsaa\Uuid\Uuid;

final class Id
{
    private $value;

    public function __construct($a_raw_value)
    {
        $this->value = $a_raw_value;
    }

    public static function next()
    {
        return new self(Uuid::uuid4()->toString());
    }

    public function value()
    {
        return $this->value;
    }
}