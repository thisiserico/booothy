<?php

namespace Booothy\Photo\Domain\Model\ValueObject;

final class ImageDetails
{
    private $hex_color;
    private $width;
    private $height;

    public function __construct($an_hex_color, $a_width, $a_height)
    {
        $this->hex_color = $an_hex_color;
        $this->width     = $a_width;
        $this->height    = $a_height;
    }

    public static function fake()
    {
        return new self('', 0, 0);
    }

    public function hexColor()
    {
        return $this->hex_color;
    }

    public function width()
    {
        return $this->width;
    }

    public function height()
    {
        return $this->height;
    }
}