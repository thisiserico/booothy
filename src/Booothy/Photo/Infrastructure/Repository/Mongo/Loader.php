<?php

namespace Booothy\Photo\Infrastructure\Repository\Mongo;

use MongoCollection;
use Booothy\Photo\Domain\Hydrator\PhotoCollection;
use Booothy\Photo\Domain\Repository\Loader as DomainLoader;

final class Loader implements DomainLoader
{
    private $mongo;
    private $hydrator;

    public function __construct(
        MongoCollection $a_mongo_collection,
        PhotoCollection $an_hydrator
    ) {
        $this->mongo    = $a_mongo_collection;
        $this->hydrator = $an_hydrator;
    }

    public function __invoke()
    {
        return $this->hydrator->__invoke($this->mongo->find());
    }
}