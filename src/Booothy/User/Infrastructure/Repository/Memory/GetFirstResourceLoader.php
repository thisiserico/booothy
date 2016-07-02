<?php

namespace Booothy\User\Infrastructure\Repository\Memory;

use Booothy\Core\Infrastructure\Repository\Memory\Handler;
use Booothy\User\Domain\Repository\UnknownResourceLoader;

final class GetFirstResourceLoader implements UnknownResourceLoader
{
    private $database_handler;

    public function __construct(Handler $a_database_handler)
    {
        $this->database_handler = $a_database_handler;
    }

    public function __invoke()
    {
        return $this->database_handler->getFirst('user');
    }
}
