<?php

namespace Booothy\User\Infrastructure\Repository\Memory;

use Booothy\User\Domain\Model\User;
use Booothy\User\Domain\Repository\ResourceSaver as DomainSaver;

final class ResourceSaver implements DomainSaver
{
    private $database;

    public function __construct(Database $a_database)
    {
        $this->database = $a_database;
    }

    public function __invoke(User $user)
    {
        $this->database->addResource($user);
    }
}