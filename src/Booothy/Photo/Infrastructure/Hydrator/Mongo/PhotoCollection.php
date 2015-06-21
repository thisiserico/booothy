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
    public function __invoke($cursor)
    {
        $collection = new Collection;

        foreach ($cursor as $document) {
            $collection->add(new Photo(
                new Id($document['_id']),
                new Quote($document['quote']),
                new Upload,
                new DateTimeImmutable($document['creation_date'])
            ));
        }

        return $collection;
    }
}