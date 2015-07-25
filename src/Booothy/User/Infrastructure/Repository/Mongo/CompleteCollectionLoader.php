<?php

namespace Booothy\User\Infrastructure\Repository\Mongo;

use MongoCollection;
use Booothy\User\Domain\Hydrator\UserCollection;
use Booothy\User\Domain\Repository\CollectionLoader;

final class CompleteCollectionLoader implements CollectionLoader
{
    private $mongo;
    private $hydrator;

    public function __construct(
        MongoCollection $a_mongo_collection,
        UserCollection $an_hydrator
    ) {
        $this->mongo    = $a_mongo_collection;
        $this->hydrator = $an_hydrator;
    }

    public function __invoke()
    {
        $cursor = $this->mongo->find();
        return $this->hydrator->__invoke($cursor);
    }
}