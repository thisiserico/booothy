<?php

namespace Booothy\Photo\Domain\Service;

use Booothy\Photo\Domain\Model\ValueObject\Upload;

class DownloadUrlGenerator
{
    private $booothy_download_pattern;

    public function __construct($the_booothy_download_pattern)
    {
        $this->booothy_download_pattern = $the_booothy_download_pattern;
    }

    public function __invoke(Upload $upload)
    {
        return preg_replace(
            '/{filename}/',
            $upload->filename(),
            $this->booothy_download_pattern
        );
    }
}