<?php

namespace Booothy\Photo\Domain\Hydrator;

interface PhotoCollection
{
    public function __invoke($resultset);
}