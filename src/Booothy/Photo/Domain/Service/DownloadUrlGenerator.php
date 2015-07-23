<?php

namespace Booothy\Photo\Domain\Service;

use Booothy\Photo\Domain\Model\ValueObject\Upload;

class DownloadUrlGenerator
{
    private $booothy_download_pattern;
    private $booothy_thumb_download_pattern;

    public function __construct(
        $the_booothy_download_pattern,
        $the_booothy_thumb_download_pattern
    ) {
        $this->booothy_download_pattern       = $the_booothy_download_pattern;
        $this->booothy_thumb_download_pattern = $the_booothy_thumb_download_pattern;
    }

    public function __invoke(Upload $upload, $generate_thumb = false)
    {
        $download_pattern = $generate_thumb
            ? $this->booothy_thumb_download_pattern
            : $this->booothy_download_pattern;

        return preg_replace('/{filename}/', $upload->filename(), $download_pattern);
    }
}