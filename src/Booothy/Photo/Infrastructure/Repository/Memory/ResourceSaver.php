<?php

namespace Booothy\Photo\Infrastructure\Repository\Memory;

use Booothy\Core\Infrastructure\Repository\Memory\Handler;
use Booothy\Photo\Domain\Model\Photo;
use Booothy\Photo\Domain\Repository\Saver as DomainSaver;

final class ResourceSaver implements DomainSaver
{
    private $database_handler;

    public function __construct(Handler $a_database_handler)
    {
        $this->database_handler = $a_database_handler;
    }

    public function __invoke(Photo $photo)
    {
        $this->database_handler->addResource(
            'photo',
            $photo->id()->value(),
            $photo
        );
    }
}