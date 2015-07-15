<?php

namespace Booothy\Photo\Infrastructure\Marshalling\Mongo;

use Booothy\Photo\Domain\Model\Photo;

final class Marshaller
{
    public function marshallResource(Photo $photo)
    {
        return [
            '_id'           => $photo->id()->value(),
            'quote'         => $photo->quote()->value(),
            'upload'        => [
                'filename'  => $photo->upload()->filename(),
                'mime_type' => $photo->upload()->mimeType(),
            ],
            'creation_date' => $photo->createdAt(),
        ];
    }
}