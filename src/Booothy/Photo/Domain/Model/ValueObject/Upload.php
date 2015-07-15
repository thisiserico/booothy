<?php

namespace Booothy\Photo\Domain\Model\ValueObject;

final class Upload
{
    const BOOOTHY    = 'booothy';
    const PROCESSING = 'processing';

    private $filename;
    private $mime_type;
    private $provider;

    private function __construct($a_filename, $a_mime_type, $a_provider)
    {
        $this->filename  = $a_filename;
        $this->mime_type = $a_mime_type;
        $this->provider  = $a_provider;
    }

    public static function atBooothy($a_filename, $a_mime_type)
    {
        return new self($a_filename, $a_mime_type, self::BOOOTHY);
    }

    public static function atProcessing($a_filename, $a_mime_type)
    {
        return new self($a_filename, $a_mime_type, self::PROCESSING);
    }

    public function filename()
    {
        return $this->filename;
    }

    public function mimeType()
    {
        return $this->mime_type;
    }

    public function provider()
    {
        return $this->provider;
    }
}