<?php

namespace Booothy\Photo\Infrastructure\Hydrator\Mongo;

use DateTimeImmutable;
use Booothy\Photo\Domain\Hydrator\PhotoCollection as Hydrator;
use Booothy\Photo\Domain\Model\Photo;
use Booothy\Photo\Domain\Model\PhotoCollection as Collection;
use Booothy\Photo\Domain\Model\ValueObject\Id;
use Booothy\Photo\Domain\Model\ValueObject\Quote;
use Booothy\Photo\Domain\Model\ValueObject\Upload;

final class PhotoCollection implements Hydrator
{
    private $resource_hydrator;

    public function __construct(PhotoResource $a_resource_hydrator)
    {
        $this->resource_hydrator = $a_resource_hydrator;
    }

    public function __invoke($cursor)
    {
        $collection = new Collection;

        foreach ($cursor as $document) {
            $collection->add($this->resource_hydrator->__invoke($document));
        }

        return $collection;
    }
}
