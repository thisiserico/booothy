<?php

namespace Booothy\Photo\Infrastructure\Repository\Mongo;

use MongoCollection;
use Booothy\Photo\Domain\Repository\Loader as DomainLoader;
use Booothy\Photo\Domain\Model\PhotoCollection;

final class Loader implements DomainLoader
{
    private $mongo;

    public function __construct(MongoCollection $a_mongo_collection)
    {
        $this->mongo = $a_mongo_collection;
    }

    public function __invoke()
    {
        return new PhotoCollection;
    }
}