<?php

namespace Booothy\User\Infrastructure\Repository\Mongo;

use MongoDB\Driver\Manager;
use MongoDB\Driver\Query;
use Booothy\User\Domain\Hydrator\UserCollection;
use Booothy\User\Domain\Repository\CollectionLoader;

final class CompleteCollectionLoader implements CollectionLoader
{
    private $mongo;
    private $hydrator;

    public function __construct(
        Manager $a_mongo_manager,
        UserCollection $an_hydrator
    ) {
        $this->mongo = $a_mongo_manager;
        $this->hydrator = $an_hydrator;
    }

    public function __invoke()
    {
        $query = new Query([]);
        $cursor = $this->mongo->executeQuery('booothy.user', $query)->toArray();

        return $this->hydrator->__invoke($cursor);
    }
}
