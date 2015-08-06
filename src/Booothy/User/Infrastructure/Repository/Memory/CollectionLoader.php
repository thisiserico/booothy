<?php

namespace Booothy\User\Infrastructure\Repository\Memory;

use Booothy\User\Domain\Model\UserCollection;
use Booothy\User\Domain\Repository\CollectionLoader as DomainLoader;

final class CollectionLoader implements DomainLoader
{
    private $database;

    public function __construct(Database $a_database)
    {
        $this->database = $a_database;
    }

    public function __invoke()
    {
        $users           = $this->database->getCollection();
        $user_collection = new UserCollection;

        foreach ($users as $user) {
            $user_collection->add($user);
        }

        return $user_collection;
    }
}