<?php

namespace Booothy\Core\Application;

interface Marshaller
{
    public function __invoke($element);
}