<?php

namespace Booothy\User\Application\Service\GetResource;

use Booothy\Core\Application\Service;
use Booothy\Core\Application\Request as CoreRequest;
use Booothy\User\Domain\Model\ValueObject\Email;
use Booothy\User\Domain\Repository\ResourceLoader;

final class UseCase implements Service
{
    private $user_loader;

    public function __construct(ResourceLoader $a_loader)
    {
        $this->user_loader = $a_loader;
    }

    public function __invoke(CoreRequest $request)
    {
        return $this->user_loader->__invoke(new Email($request->email));
    }
}
