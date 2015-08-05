<?php

namespace Booothy\User\Infrastructure\Repository\Memory;

use Booothy\User\Domain\Model\ValueObject\Email;
use Booothy\User\Domain\Repository\ResourceLoader as DomainLoader;

final class ResourceLoader implements DomainLoader
{
    private $database;

    public function __construct(Database $a_database)
    {
        $this->database = $a_database;
    }

    public function __invoke(Email $email)
    {
        return $this->database->getResource($email);
    }
}