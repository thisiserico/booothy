<?php

namespace Booothy\Photo\Domain\Event;

use League\Event\AbstractEvent;
use Booothy\Photo\Domain\Model\Photo;

final class NewPhotoUploaded extends AbstractEvent
{
    public $photo;
    public $temporary_location;

    public function __construct(Photo $a_photo, $a_location)
    {
        $this->photo              = $a_photo;
        $this->temporary_location = $a_location;
    }
}