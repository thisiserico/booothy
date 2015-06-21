<?php

namespace Booothy\Photo\Application\Service\GetCompleteCollection;

use Booothy\Photo\Domain\Repository\Loader;

final class UseCase
{
    private $photo_loader;

    public function __construct(Loader $a_loader)
    {
        $this->photo_loader = $a_loader;
    }

    public function __invoke(Request $request)
    {
        return new Response($this->photo_loader->__invoke());
    }
}