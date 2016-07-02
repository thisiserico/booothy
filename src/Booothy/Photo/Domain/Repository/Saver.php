<?php

namespace Booothy\Photo\Domain\Repository;

use Booothy\Photo\Domain\Model\Photo;

interface Saver
{
    public function __invoke(Photo $photo);
}
