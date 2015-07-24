<?php

namespace Booothy\User\Domain\Repository;

use Booothy\User\Domain\Model\ValueObject\Email;

interface ResourceLoader
{
    public function __invoke(Email $email);
}