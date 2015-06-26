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
            $upload_provider = 'At' . ucfirst($document['upload']['provider']);

            $collection->add(new Photo(
                new Id($document['_id']),
                new Quote($document['quote']),
                Upload::$upload_provider(
                    $document['upload']['filename'],
                    $document['upload']['mime_type']
                ),
                new DateTimeImmutable($document['creation_date'])
            ));
        }

        return $collection;
    }
}