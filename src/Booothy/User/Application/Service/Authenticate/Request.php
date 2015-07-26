<?php

namespace Booothy\User\Application\Service\Authenticate;

use Booothy\Core\Application\Request as CoreRequest;

final class Request implements CoreRequest
{
    public $id_token;

    public function __construct($an_id_token)
    {
        $this->id_token = $an_id_token;
    }
}