<?php

namespace Booothy\Photo\Infrastructure\Repository\Memory;

use Booothy\Core\Infrastructure\Repository\Memory\Handler;
use Booothy\Photo\Domain\Model\ValueObject\Id;
use Booothy\Photo\Domain\Repository\Exception\NonExistingResource;
use Booothy\Photo\Domain\Repository\ResourceLoader as DomainLoader;

final class ResourceLoader implements DomainLoader
{
    private $database_handler;

    public function __construct(Handler $a_database_handler)
    {
        $this->database_handler = $a_database_handler;
    }

    public function __invoke(Id $id)
    {
        return $this->database_handler->getResource(
            'photo',
            $id->value(),
            function () {
                throw new NonExistingResource;
            }
        );
    }
}
