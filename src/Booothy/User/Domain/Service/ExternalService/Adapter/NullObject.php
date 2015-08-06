<?php

namespace Booothy\User\Domain\Service\ExternalService\Adapter;

use Booothy\User\Domain\Repository\UnknownResourceLoader;
use Booothy\User\Domain\Service\ExternalService\Adapter;
use Booothy\User\Domain\Service\ExternalService\Exception\InvalidUser;

final class NullObject implements Adapter
{
    private $resource_loader;

    public function __construct(UnknownResourceLoader $a_resource_loader)
    {
        $this->resource_loader = $a_resource_loader;
    }

    public function getUserEmail($id_token)
    {
        $unkown_user = $this->resource_loader->__invoke();

        if (!$unkown_user) {
            throw new InvalidUser;
        }

        return $unkown_user->email()->value();
    }
}