<?php

namespace Booothy\User\Infrastructure\Repository\Memory;

use Booothy\Core\Infrastructure\Repository\Memory\Handler;
use Booothy\User\Domain\Model\ValueObject\Email;
use Booothy\User\Domain\Repository\Exception\NonExistingResource;
use Booothy\User\Domain\Repository\ResourceLoader as DomainLoader;

final class ResourceLoader implements DomainLoader
{
    private $database_handler;

    public function __construct(Handler $a_database_handler)
    {
        $this->database_handler = $a_database_handler;
    }

    public function __invoke(Email $email)
    {
        return $this->database_handler->getResource(
            'user',
            $email->value(),
            function () {
                throw new NonExistingResource;
            }
        );
    }
}
