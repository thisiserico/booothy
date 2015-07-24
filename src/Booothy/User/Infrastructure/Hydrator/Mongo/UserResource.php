<?php

namespace Booothy\User\Infrastructure\Hydrator\Mongo;

use Booothy\User\Domain\Hydrator\UserResource as Hydrator;
use Booothy\User\Domain\Model\User;
use Booothy\User\Domain\Model\ValueObject\Email;
use Booothy\User\Domain\Model\ValueObject\Id;

final class UserResource implements Hydrator
{
    public function __invoke(array $document)
    {
        return new User(new Id($document['_id']), new Email($document['email']));
    }
}