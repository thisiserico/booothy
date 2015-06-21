<?php

namespace Booothy\Photo\Application\Marshaller;

use Booothy\Core\Application\Marshaller;
use Booothy\Photo\Domain\Model\Photo;

final class Collection implements Marshaller
{
    public function __invoke($elements)
    {
        return array_map([$this, 'marshallElement'], $elements->photos());
    }

    private function marshallElement(Photo $element)
    {
        return [
            'id'            => $element->id()->value(),
            'quote'         => $element->quote()->value(),
            'upload'        => [],
            'creation_date' => $element->createdAt(),
        ];
    }
}