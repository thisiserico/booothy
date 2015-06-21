<?php

namespace Booothy\Photo\Infrastructure\Repository\Mongo;

use MongoCollection;
use Booothy\Photo\Domain\Hydrator\PhotoCollection;
use Booothy\Photo\Domain\Repository\Loader as DomainLoader;

final class NewerFirstLoader implements DomainLoader
{
    private $mongo;
    private $hydrator;

    public function __construct(
        MongoCollection $a_mongo_collection,
        PhotoCollection $an_hydrator
    ) {
        $this->mongo    = $a_mongo_collection;
        $this->hydrator = $an_hydrator;
    }

    public function __invoke($requested_page, $photos_per_page)
    {
        $cursor = $this->mongo
            ->find()
            ->sort(['creation_date' => -1])
            ->skip(($requested_page - 1) * $photos_per_page)
            ->limit($photos_per_page);

        return $this->hydrator->__invoke($cursor);
    }
}