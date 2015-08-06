<?php

namespace Booothy\User\Infrastructure\Repository\Memory;

use Booothy\User\Domain\Repository\UnknownResourceLoader;

final class GetFirstResourceLoader implements UnknownResourceLoader
{
    private $database;

    public function __construct(Database $a_database)
    {
        $this->database = $a_database;
    }

    public function __invoke()
    {
        return $this->database->getFirst();
    }
}