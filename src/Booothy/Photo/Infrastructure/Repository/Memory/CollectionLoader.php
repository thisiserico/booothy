<?php

namespace Booothy\Photo\Infrastructure\Repository\Memory;

use Booothy\Core\Infrastructure\Repository\Memory\Handler;
use Booothy\Photo\Domain\Model\PhotoCollection;
use Booothy\Photo\Domain\Repository\Loader as DomainLoader;

final class CollectionLoader implements DomainLoader
{
    private $database_handler;

    public function __construct(Handler $a_database_handler)
    {
        $this->database_handler = $a_database_handler;
    }

    public function __invoke($requested_page, $photos_per_page)
    {
        $photos = $this->database_handler->getCollection('photo');
        $photos = array_slice(
            $photos,
            ($requested_page - 1) * $photos_per_page
        );

        $photo_collection = new PhotoCollection;

        foreach ($photos as $poto) {
            $photo_collection->add($poto);
        }

        return $photo_collection;
    }
}