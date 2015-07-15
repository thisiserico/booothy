<?php

namespace Booothy\Photo\Application\Listener;

use League\Event\AbstractListener;
use League\Event\EventInterface;
use Symfony\Component\Filesystem\Filesystem;
use Booothy\Photo\Domain\Model\ValueObject\Upload;
use Booothy\Photo\Domain\Repository\Saver;

final class GenerateUploads extends AbstractListener
{
    private $file_handler;
    private $saver_repository;

    public function __construct(
        Filesystem $a_filesystem_handler,
        Saver $a_saver_repository
    ) {
        $this->file_handler     = $a_filesystem_handler;
        $this->saver_repository = $a_saver_repository;
    }

    public function handle(EventInterface $event)
    {
        $photo              = $event->photo;
        $temporary_location = $event->temporary_location;

        $this->file_handler->copy(
            $temporary_location,
            BASE_DIR . 'var/uploads/' . $photo->upload()->filename()
        );

        $this->file_handler->remove([$temporary_location]);

        $photo->isStoredIn(Upload::BOOOTHY);
        $this->saver_repository->__invoke($photo);

        return $photo;
    }
}