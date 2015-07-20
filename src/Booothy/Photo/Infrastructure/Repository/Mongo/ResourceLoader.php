<?php

namespace Booothy\Photo\Infrastructure\Repository\Mongo;

use MongoCollection;
use Booothy\Photo\Domain\Hydrator\PhotoResource;
use Booothy\Photo\Domain\Model\ValueObject\Id;
use Booothy\Photo\Domain\Repository\ResourceLoader as DomainLoader;
use Booothy\Photo\Domain\Repository\Exception\NonExistingResource;

final class ResourceLoader implements DomainLoader
{
    private $mongo;
    private $hydrator;

    public function __construct(
        MongoCollection $a_mongo_collection,
        PhotoResource $an_hydrator
    ) {
        $this->mongo    = $a_mongo_collection;
        $this->hydrator = $an_hydrator;
    }

    public function __invoke(Id $id)
    {
        $cursor = $this->mongo->find(['_id' => $id->value()]);
        $cursor->next();

        if (!$cursor->valid()) {
            throw new NonExistingResource;
        }

        return $this->hydrator->__invoke($cursor->current());
    }
}