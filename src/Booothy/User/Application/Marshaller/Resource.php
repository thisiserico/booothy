<?php

namespace Booothy\User\Application\Marshaller;

use Booothy\Core\Application\Marshaller;

final class Resource implements Marshaller
{
    public function __invoke($element)
    {
        return [
            'id'     => $element->email()->value(),
            'avatar' => $element->avatar(),
        ];
    }
}