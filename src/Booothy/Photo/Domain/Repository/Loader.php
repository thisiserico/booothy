<?php

namespace Booothy\Photo\Domain\Repository;

interface Loader
{
    public function __invoke($requested_page, $photos_per_page);
}