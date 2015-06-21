<?php

namespace Booothy\Photo\Application\Service\GetCompleteCollection;

use Booothy\Core\Application\Request as CoreRequest;

final class Request implements CoreRequest
{
    public $requested_page;
    public $photos_per_page;

    public function __construct(
        $the_requested_page,
        $the_requested_photos_per_page
    ) {
        $this->requested_page  = max(1, $the_requested_page);
        $this->photos_per_page = $the_requested_photos_per_page;
    }
}