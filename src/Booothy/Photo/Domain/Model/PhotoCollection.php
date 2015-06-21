<?php

namespace Booothy\Photo\Domain\Model;

final class PhotoCollection
{
    private $photos;

    public function __construct()
    {
        $this->photos = [];
    }

    public function add(Photo $photo)
    {
        $this->photos[] = $photo;
    }

    public function photos()
    {
        return $this->photos;
    }
}