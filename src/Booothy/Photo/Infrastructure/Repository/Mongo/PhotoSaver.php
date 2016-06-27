<?php

namespace Booothy\Photo\Infrastructure\Repository\Mongo;

use MongoDB\Driver\Command;
use MongoDB\Driver\Manager;
use Booothy\Photo\Domain\Model\Photo;
use Booothy\Photo\Domain\Repository\Saver;
use Booothy\Photo\Infrastructure\Marshalling\Mongo\Marshaller;

final class PhotoSaver implements Saver
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

    public function __invoke(Photo $photo)
    {
        $marshalled_photo = $this->marshaller->marshallResource($photo);

        $command = new Command([
            'insert' => 'photo',
            'documents' => [$marshalled_photo],
        ]);

        $this->mongo->executeCommand('booothy', $command);
    }
}
