<?php

namespace Booothy\User\Application\Service\PostResource;

use Booothy\Core\Application\Request as CoreRequest;

final class Request implements CoreRequest
{
    public $email;

    public function __construct($an_email)
    {
        $this->email = $an_email;
    }
}
