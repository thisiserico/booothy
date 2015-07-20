<?php

namespace Booothy\Photo\Infrastructure\Hydrator\Mongo;

use DateTimeImmutable;
use Booothy\Photo\Domain\Hydrator\PhotoResource as Hydrator;
use Booothy\Photo\Domain\Model\Photo;
use Booothy\Photo\Domain\Model\ValueObject\Id;
use Booothy\Photo\Domain\Model\ValueObject\Quote;
use Booothy\Photo\Domain\Model\ValueObject\Upload;

final class PhotoResource implements Hydrator
{
    public function __invoke(array $document)
    {
        $upload_provider = 'atProcessing';

        if (array_key_exists('provider', $document['upload'])) {
            $upload_provider = 'at' . ucfirst($document['upload']['provider']);
        }

        return new Photo(
            new Id($document['_id']),
            new Quote($document['quote']),
            Upload::$upload_provider(
                $document['upload']['filename'],
                $document['upload']['mime_type']
            ),
            new DateTimeImmutable($document['creation_date'])
        );
    }
}