<?php

namespace Booothy\Photo\Infrastructure\Repository\Mongo;

use MongoCollection;
use Booothy\Photo\Domain\Model\Photo;
use Booothy\Photo\Domain\Repository\Saver;
use Booothy\Photo\Infrastructure\Marshalling\Mongo\Marshaller;

final class PhotoSaver implements Saver
{
    private $mongo;
    private $marshaller;

    public function __construct(
        MongoCollection $a_mongo_collection,
        Marshaller $a_marshaller
    ) {
        $this->mongo      = $a_mongo_collection;
        $this->marshaller = $a_marshaller;
    }

    public function __invoke(Photo $photo)
    {
        $marshalled_photo = $this->marshaller->marshallResource($photo);

        $this->mongo->update(
            ['_id' => $marshalled_photo['_id']],
            $marshalled_photo,
            ['upsert' => true]
        );
    }
}