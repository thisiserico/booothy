<?php

namespace Booothy\Photo\Application\Service\GetCompleteCollection;

use Booothy\Core\Application\Service;
use Booothy\Core\Application\Request as CoreRequest;
use Booothy\Photo\Domain\Repository\Loader;

final class UseCase implements Service
{
    private $photo_loader;

    public function __construct(Loader $a_loader)
    {
        $this->photo_loader = $a_loader;
    }

    public function __invoke(CoreRequest $request)
    {
        return $this->photo_loader->__invoke(
            $request->requested_page,
            $request->photos_per_page
        );
    }
}
