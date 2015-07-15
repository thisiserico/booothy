<?php

namespace Booothy\Photo\Application\Service\PostResource;

use League\Event\Emitter;
use Booothy\Core\Application\Service;
use Booothy\Core\Application\Request as CoreRequest;
use Booothy\Photo\Domain\Event\NewPhotoUploaded;
use Booothy\Photo\Domain\Model\Photo;
use Booothy\Photo\Domain\Repository\Saver;

final class UseCase implements Service
{
    private $photo_saver;
    private $event_emitter;

    public function __construct(Saver $a_photo_saver, Emitter $an_event_emitter)
    {
        $this->photo_saver   = $a_photo_saver;
        $this->event_emitter = $an_event_emitter;
    }

    public function __invoke(CoreRequest $request)
    {
        $photo = Photo::generateNew($request->quote, $request->upload_mime_type);

        $this->photo_saver->__invoke($photo);
        $this->event_emitter->emit(new NewPhotoUploaded(
            $photo,
            $request->upload_temporaty_location
        ));

        return $photo;
    }
}