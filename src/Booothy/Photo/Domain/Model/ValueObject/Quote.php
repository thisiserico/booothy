<?php

namespace Booothy\Photo\Domain\Model\ValueObject;

final class Quote
{
    private $value;

    public function __construct($a_raw_value)
    {
        $this->value = $a_raw_value;
    }

    public function value()
    {
        return $this->value;
    }
}
