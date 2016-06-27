<?php

namespace Booothy\Core\Application;

use Booothy\Core\Application\Request;

interface Service
{
    public function __invoke(Request $request);
}
