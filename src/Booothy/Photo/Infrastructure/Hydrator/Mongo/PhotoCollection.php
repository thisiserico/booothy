<?php

namespace Booothy\Photo\Infrastructure\Hydrator\Mongo;

use Booothy\Photo\Domain\Hydrator\PhotoCollection as Hydrator;
use Booothy\Photo\Domain\Model\PhotoCollection as Collection;

final class PhotoCollection implements Hydrator
{
    public function __invoke($cursor)
    {
        return new Collection;
    }
}