<?php

namespace Booothy\Photo\Application\Listener;

use Intervention\Image\ImageManager;
use League\Event\AbstractListener;
use League\Event\EventInterface;
use Symfony\Component\Filesystem\Filesystem;
use Booothy\Photo\Domain\Model\Photo;
use Booothy\Photo\Domain\Model\ValueObject\Upload;
use Booothy\Photo\Domain\Repository\Saver;

final class GenerateUploads extends AbstractListener
{
    const THUMB_SIZE = 300;

    private $file_handler;
    private $image_manager;
    private $saver_repository;
    private $uploads_folder;
    private $thumbnails_folder;

    public function __construct(
        Filesystem $a_filesystem_handler,
        ImageManager $an_image_manaer,
        Saver $a_saver_repository,
        $an_uploads_folder,
        $a_thumbnails_folder
    ) {
        $this->file_handler = $a_filesystem_handler;
        $this->image_manager = $an_image_manaer;
        $this->saver_repository = $a_saver_repository;
        $this->uploads_folder = $an_uploads_folder;
        $this->thumbnails_folder = $a_thumbnails_folder;
    }

    public function handle(EventInterface $event)
    {
        $photo = $event->photo;
        $temporary_location = $event->temporary_location;

        $this->generateThumb($photo, $temporary_location);
        $this->moveOriginalImage($photo, $temporary_location);
        $this->updateImageLocation($photo);

        return $photo;
    }

    private function generateThumb(Photo $photo, $temporary_location)
    {
        $image = $this->image_manager->make($temporary_location);
        $image->widen(self::THUMB_SIZE);
        $image->save($this->thumbnails_folder . $photo->upload()->filename());
    }

    private function moveOriginalImage(Photo $photo, $temporary_location)
    {
        $this->file_handler->copy(
            $temporary_location,
            $this->uploads_folder . $photo->upload()->filename()
        );

        $this->file_handler->remove([$temporary_location]);
    }

    private function updateImageLocation(Photo $photo)
    {
        $photo->isStoredIn(Upload::BOOOTHY);
        $this->saver_repository->__invoke($photo);
    }
}
