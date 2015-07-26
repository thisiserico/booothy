<?php

namespace Booothy\Photo\Application\Marshaller;

use Booothy\Core\Application\Marshaller;
use Booothy\Photo\Domain\Service\DownloadUrlGenerator;

final class Resource implements Marshaller
{
    private $download_url_generator;

    public function __construct(DownloadUrlGenerator $a_download_url_generator)
    {
        $this->download_url_generator = $a_download_url_generator;
    }

    public function __invoke($element)
    {
        return [
            'id'            => $element->id()->value(),
            'quote'         => $element->quote()->value(),
            'upload'        => [
                'filename'           => $element->upload()->filename(),
                'mime_type'          => $element->upload()->mimeType(),
                'download_url'       => $this->download_url_generator->__invoke(
                    $element->upload()
                ),
                'thumb_download_url' => $this->download_url_generator->__invoke(
                    $element->upload(),
                    true
                ),
            ],
            'image_details' => [
                'hex_color' => $element->imageDetails()->hexColor(),
                'width'     => $element->imageDetails()->width(),
                'height'    => $element->imageDetails()->height(),
            ],
            'creation_date' => $element->createdAt(),
            'user'          => $element->createdBy()->value(),
        ];
    }
}