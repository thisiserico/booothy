<?php

namespace Booothy\Photo\Application\Service\GetCompleteCollection;

use Booothy\Photo\Domain\Model\PhotoCollection;

final class Response
{
    public $collection;

    public function __construct(PhotoCollection $a_collection)
    {
        $this->collection = $a_collection;
    }
}