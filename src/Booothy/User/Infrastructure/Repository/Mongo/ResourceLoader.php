<?php

namespace Booothy\User\Infrastructure\Repository\Mongo;

use MongoDB\Driver\Manager;
use MongoDB\Driver\Query;
use Booothy\User\Domain\Hydrator\UserResource;
use Booothy\User\Domain\Model\ValueObject\Email;
use Booothy\User\Domain\Repository\ResourceLoader as DomainLoader;
use Booothy\User\Domain\Repository\Exception\NonExistingResource;

final class ResourceLoader implements DomainLoader
{
    private $mongo;
    private $hydrator;

    public function __construct(
        Manager $a_mongo_manager,
        UserResource $an_hydrator
    ) {
        $this->mongo = $a_mongo_manager;
        $this->hydrator = $an_hydrator;
    }

    public function __invoke(Email $email)
    {
        $query = new Query(['_id' => $email->value()]);
        $cursor = $this->mongo->executeQuery('booothy.user', $query)->toArray();

        if (empty($cursor)) {
            throw new NonExistingResource;
        }

        return $this->hydrator->__invoke($cursor[0]);
    }
}
