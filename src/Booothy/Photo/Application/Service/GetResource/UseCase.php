<?php

namespace Booothy\Photo\Application\Service\GetResource;

use Booothy\Core\Application\Service;
use Booothy\Core\Application\Request as CoreRequest;
use Booothy\Photo\Domain\Model\ValueObject\Id;
use Booothy\Photo\Domain\Repository\ResourceLoader;

final class UseCase implements Service
{
    private $photo_loader;

    public function __construct(ResourceLoader $a_loader)
    {
        $this->photo_loader = $a_loader;
    }

    public function __invoke(CoreRequest $request)
    {
        return $this->photo_loader->__invoke(new Id($request->id));
    }
}