<?php

namespace Booothy\User\Infrastructure\Repository\Memory;

use Booothy\Core\Infrastructure\Repository\Memory\Handler;
use Booothy\User\Domain\Model\UserCollection;
use Booothy\User\Domain\Repository\CollectionLoader as DomainLoader;

final class CollectionLoader implements DomainLoader
{
    private $database_handler;

    public function __construct(Handler $a_database_handler)
    {
        $this->database_handler = $a_database_handler;
    }

    public function __invoke()
    {
        $users = $this->database_handler->getCollection('user');
        $user_collection = new UserCollection;

        foreach ($users as $user) {
            $user_collection->add($user);
        }

        return $user_collection;
    }
}
