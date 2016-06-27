<?php

namespace Booothy\Photo\Infrastructure\Repository\Mongo;

use MongoDB\Driver\Manager;
use MongoDB\Driver\Query;
use Booothy\Photo\Domain\Hydrator\PhotoResource;
use Booothy\Photo\Domain\Model\ValueObject\Id;
use Booothy\Photo\Domain\Repository\ResourceLoader as DomainLoader;
use Booothy\Photo\Domain\Repository\Exception\NonExistingResource;

final class ResourceLoader implements DomainLoader
{
    private $mongo;
    private $hydrator;

    public function __construct(
        Manager $a_mongo_manager,
        PhotoResource $an_hydrator
    ) {
        $this->mongo = $a_mongo_manager;
        $this->hydrator = $an_hydrator;
    }

    public function __invoke(Id $id)
    {
        $query = new Query(['_id' => $id->value()]);
        $cursor = $this->mongo->executeQuery('booothy.photo', $query)->toArray();

        if (empty($cursor)) {
            throw new NonExistingResource;
        }

        return $this->hydrator->__invoke($cursor[0]);
    }
}
