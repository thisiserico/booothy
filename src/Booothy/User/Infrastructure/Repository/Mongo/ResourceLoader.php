<?php

namespace Booothy\User\Infrastructure\Repository\Mongo;

use MongoCollection;
use Booothy\User\Domain\Hydrator\UserResource;
use Booothy\User\Domain\Model\ValueObject\Email;
use Booothy\User\Domain\Repository\ResourceLoader as DomainLoader;
use Booothy\User\Domain\Repository\Exception\NonExistingResource;

final class ResourceLoader implements DomainLoader
{
    private $mongo;
    private $hydrator;

    public function __construct(
        MongoCollection $a_mongo_collection,
        UserResource $an_hydrator
    ) {
        $this->mongo    = $a_mongo_collection;
        $this->hydrator = $an_hydrator;
    }

    public function __invoke(Email $email)
    {
        $cursor = $this->mongo->find(['_id' => $email->value()]);
        $cursor->next();

        if (!$cursor->valid()) {
            throw new NonExistingResource;
        }

        return $this->hydrator->__invoke($cursor->current());
    }
}