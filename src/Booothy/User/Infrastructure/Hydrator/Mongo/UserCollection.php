<?php

namespace Booothy\User\Infrastructure\Hydrator\Mongo;

use Booothy\User\Domain\Hydrator\UserCollection as Hydrator;
use Booothy\User\Domain\Model\User;
use Booothy\User\Domain\Model\UserCollection as Collection;
use Booothy\User\Domain\Model\ValueObject\Email;
use Booothy\User\Domain\Model\ValueObject\Id;

final class UserCollection implements Hydrator
{
    private $resource_hydrator;

    public function __construct(UserResource $a_resource_hydrator)
    {
        $this->resource_hydrator = $a_resource_hydrator;
    }

    public function __invoke($cursor)
    {
        $collection = new Collection;

        foreach ($cursor as $document) {
            $collection->add($this->resource_hydrator->__invoke($document));
        }

        return $collection;
    }
}
