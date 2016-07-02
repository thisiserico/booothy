<?php

namespace Booothy\Photo\Domain\Repository;

use Booothy\Photo\Domain\Model\ValueObject\Id;

interface ResourceLoader
{
    public function __invoke(Id $id);
}
