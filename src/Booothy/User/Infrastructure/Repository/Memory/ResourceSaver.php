<?php

namespace Booothy\User\Infrastructure\Repository\Memory;

use Booothy\Core\Infrastructure\Repository\Memory\Handler;
use Booothy\User\Domain\Model\User;
use Booothy\User\Domain\Repository\ResourceSaver as DomainSaver;

final class ResourceSaver implements DomainSaver
{
    private $database_handler;

    public function __construct(Handler $a_database_handler)
    {
        $this->database_handler = $a_database_handler;
    }

    public function __invoke(User $user)
    {
        $this->database_handler->addResource(
            'user',
            $user->email()->value(),
            $user
        );
    }
}
