<?php

namespace Booothy\User\Application\Service\GetCollection;

use Booothy\Core\Application\Service;
use Booothy\Core\Application\Request as CoreRequest;
use Booothy\User\Domain\Repository\CollectionLoader;

final class UseCase implements Service
{
    private $user_loader;

    public function __construct(CollectionLoader $a_loader)
    {
        $this->user_loader = $a_loader;
    }

    public function __invoke(CoreRequest $request)
    {
        return $this->user_loader->__invoke();
    }
}