<?php

namespace Booothy\User\Domain\Service\ExternalService;

interface Adapter
{
    public function getUserEmail($id_token);
}
