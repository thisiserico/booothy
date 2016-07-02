<?php

namespace Booothy\User\Infrastructure\Repository\Mongo;

use MongoDB\Driver\Command;
use MongoDB\Driver\Manager;
use Booothy\User\Domain\Model\User;
use Booothy\User\Domain\Repository\ResourceSaver as DomainSaver;
use Booothy\User\Infrastructure\Marshalling\Mongo\Marshaller;

final class ResourceSaver implements DomainSaver
{
    private $mongo;
    private $marshaller;

    public function __construct(
        Manager $a_mongo_manager,
        Marshaller $a_marshaller
    ) {
        $this->mongo = $a_mongo_manager;
        $this->marshaller = $a_marshaller;
    }

    public function __invoke(User $user)
    {
        $marshalled_user = $this->marshaller->marshallResource($user);

        $command = new Command([
            'insert' => 'user',
            'documents' => [$marshalled_user],
        ]);

        $this->mongo->executeCommand('booothy', $command);
    }
}
