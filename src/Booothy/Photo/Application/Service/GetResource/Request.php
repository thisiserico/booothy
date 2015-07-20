<?php

namespace Booothy\Photo\Application\Service\GetResource;

use Booothy\Core\Application\Request as CoreRequest;

final class Request implements CoreRequest
{
    public $id;

    public function __construct($an_id)
    {
        $this->id = $an_id;
    }
}