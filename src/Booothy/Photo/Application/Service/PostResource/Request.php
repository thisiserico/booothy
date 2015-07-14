<?php

namespace Booothy\Photo\Application\Service\PostResource;

use Booothy\Core\Application\Request as CoreRequest;

final class Request implements CoreRequest
{
    public $quote;
    public $upload_mime_type;
    public $upload_temporaty_location;

    public function __construct(
        $a_quote,
        $an_upload_mime_type,
        $an_upload_temporary_location
    ) {
        $this->quote                     = $a_quote;
        $this->upload_mime_type          = $an_upload_mime_type;
        $this->upload_temporaty_location = $an_upload_temporary_location;
    }
}