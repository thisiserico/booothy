<?php

namespace Booothy\User\Infrastructure\Repository\Mongo;

use MongoCollection;
use Booothy\User\Domain\Model\User;
use Booothy\User\Domain\Repository\ResourceSaver as DomainSaver;
use Booothy\User\Infrastructure\Marshalling\Mongo\Marshaller;

final class ResourceSaver implements DomainSaver
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

    public function __invoke(User $user)
    {
        $marshalled_user = $this->marshaller->marshallResource($user);

        $this->mongo->update(
            ['_id' => $marshalled_user['_id']],
            $marshalled_user,
            ['upsert' => true]
        );
    }
}