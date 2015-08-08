<?php

namespace Booothy\User\Infrastructure\Marshalling\Mongo;

use Booothy\User\Domain\Model\User;

final class Marshaller
{
    public function marshallResource(User $user)
    {
        return ['_id' => $user->email()->value()];
    }
}