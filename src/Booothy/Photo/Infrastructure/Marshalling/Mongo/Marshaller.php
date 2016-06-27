<?php

namespace Booothy\Photo\Infrastructure\Marshalling\Mongo;

use Booothy\Photo\Domain\Model\Photo;

final class Marshaller
{
    public function marshallResource(Photo $photo)
    {
        return [
            '_id' => $photo->id()->value(),
            'quote' => $photo->quote()->value(),
            'upload' => [
                'filename'  => $photo->upload()->filename(),
                'mime_type' => $photo->upload()->mimeType(),
            ],
            'image_details' => [
                'hex_color' => $photo->imageDetails()->hexColor(),
                'width' => $photo->imageDetails()->width(),
                'height' => $photo->imageDetails()->height(),
            ],
            'creation_date' => $photo->createdAt(),
            'user' => $photo->createdBy()->value(),
        ];
    }
}
