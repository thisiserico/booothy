<?php

namespace Booothy\User\Infrastructure\Hydrator\Mongo;

use stdClass;
use Booothy\User\Domain\Hydrator\UserResource as Hydrator;
use Booothy\User\Domain\Model\User;
use Booothy\User\Domain\Model\ValueObject\Email;

final class UserResource implements Hydrator
{
    public function __invoke(stdClass $document)
    {
        return new User(new Email($document->_id));
    }
}
