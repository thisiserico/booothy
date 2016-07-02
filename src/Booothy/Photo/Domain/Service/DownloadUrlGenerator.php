<?php

namespace Booothy\Photo\Domain\Service;

use Booothy\Photo\Domain\Model\ValueObject\Upload;

final class DownloadUrlGenerator
{
    private $booothy_url;
    private $booothy_download_uri;
    private $booothy_thumb_download_uri;

    public function __construct(
        $the_booothy_url,
        $the_booothy_download_uri,
        $the_booothy_thumb_download_uri
    ) {
        $this->booothy_url = $the_booothy_url;
        $this->booothy_download_uri = $the_booothy_download_uri;
        $this->booothy_thumb_download_uri = $the_booothy_thumb_download_uri;
    }

    public function __invoke(Upload $upload, $generate_thumb = false)
    {
        $download_pattern_uri = $generate_thumb
            ? $this->booothy_thumb_download_uri
            : $this->booothy_download_uri;

        $download_pattern = sprintf(
            '%s/%s',
            $this->booothy_url,
            $download_pattern_uri
        );

        return preg_replace('/{filename}/', $upload->filename(), $download_pattern);
    }
}

