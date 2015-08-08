<?php

namespace Booothy\User\Application\Service\PostResource;

use Booothy\Core\Application\Service;
use Booothy\Core\Application\Request as CoreRequest;
use Booothy\User\Domain\Model\User;
use Booothy\User\Domain\Repository\ResourceSaver;

final class UseCase implements Service
{
    private $user_saver;

    public function __construct(ResourceSaver $a_saver)
    {
        $this->user_saver = $a_saver;
    }

    public function __invoke(CoreRequest $request)
    {
        return $this->user_saver->__invoke(User::generate($request->email));
    }
}