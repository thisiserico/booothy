<?php

namespace Booothy\Photo\Domain\Hydrator;

interface PhotoResource
{
    public function __invoke(array $photo);
}