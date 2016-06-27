<?php

namespace BooothyTest\Photo\Application\Listener;

use Mockery as m;
use PHPUnit_Framework_TestCase;
use Intervention\Image\ImageManager;
use Intervention\Image\Image;
use Symfony\Component\Filesystem\Filesystem;
use Booothy\Photo\Application\Listener\GenerateUploads;
use Booothy\Photo\Domain\Repository\Saver;
use Booothy\Photo\Domain\Model\Photo;
use Booothy\Photo\Domain\Model\ValueObject\Upload;
use Booothy\Photo\Domain\Event\NewPhotoUploaded;
use Booothy\User\Domain\Model\ValueObject\Email;

final class GenerateUploadsTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        $this->file_handler = null;
        $this->image_manager = null;
        $this->saver_repository = null;
        $this->photo = null;
        $this->temporary_location = null;
        $this->event = null;
        $this->uploads_folder = null;
        $this->thumbnails_folder = null;

        m::close();
    }

    /** @test */
    public function shouldMoveTheUploadToTheFinalLocations()
    {
        $this->givenAFileHandler();
        $this->andAnImageManager();
        $this->andASaverRepository();
        $this->andAPhoto();
        $this->andATemporaryLocation();
        $this->havingANewPhotoUploadedEvent();
        $this->andAnUploadsFolder();
        $this->andAThumbnailsFolder();
        $this->thenTheFileHandlerShouldMoveTheFile();
        $this->andTheThumbnailShouldBeGenerated();
        $this->whenExecutingTheListener();
    }

    /** @test */
    public function shouldPersistThePhotoModifications()
    {
        $this->givenAFileHandler();
        $this->andAnImageManager();
        $this->andASaverRepository();
        $this->andAPhoto();
        $this->andATemporaryLocation();
        $this->havingANewPhotoUploadedEvent();
        $this->andAnUploadsFolder();
        $this->andAThumbnailsFolder();
        $this->thenThePhotoModificationGetPersisted();
        $this->whenExecutingTheListener();
    }

    /** @test */
    public function shouldChangeTheUploadProvider()
    {
        $this->givenAFileHandler();
        $this->andAnImageManager();
        $this->andASaverRepository();
        $this->andAPhoto();
        $this->andATemporaryLocation();
        $this->havingANewPhotoUploadedEvent();
        $this->andAnUploadsFolder();
        $this->andAThumbnailsFolder();
        $modified_photo = $this->whenExecutingTheListener();

        $this->assertEquals(
            Upload::BOOOTHY,
            $modified_photo->upload()->provider()
        );
    }

    private function givenAFileHandler()
    {
        $this->file_handler = m::mock(Filesystem::class);
        $this->file_handler->shouldReceive('copy')->byDefault();
        $this->file_handler->shouldReceive('remove')->byDefault();
    }

    private function andAnImageManager()
    {
        $image_stub = m::mock(Image::class);
        $image_stub->shouldReceive('widen')->byDefault();
        $image_stub->shouldReceive('save')->byDefault();

        $this->image_manager = m::mock(ImageManager::class);
        $this->image_manager
            ->shouldReceive('make')
            ->andReturn($image_stub)
            ->byDefault();
    }

    private function andASaverRepository()
    {
        $this->saver_repository = m::mock(Saver::class);
        $this->saver_repository->shouldReceive('__invoke')->byDefault();
    }

    private function andAPhoto()
    {
        $this->photo = Photo::generateNew('quote', 'image/png', new Email('email'));
    }

    private function andATemporaryLocation()
    {
        $this->temporary_location = '/tmp/file';
    }

    private function havingANewPhotoUploadedEvent()
    {
        $this->event = new NewPhotoUploaded(
            $this->photo,
            $this->temporary_location
        );
    }

    private function andAnUploadsFolder()
    {
        $this->uploads_folder = '/uploads/';
    }

    private function andAThumbnailsFolder()
    {
        $this->thumbnails_folder = '/thumbnails/';
    }

    private function thenTheFileHandlerShouldMoveTheFile()
    {
        $this->file_handler
            ->shouldReceive('copy')
            ->atLeast()->times(1)
            ->with(
                $this->temporary_location,
                $this->uploads_folder . $this->photo->upload()->filename()
            );

        $this->file_handler
            ->shouldReceive('remove')
            ->atLeast()->times(1)
            ->with([$this->temporary_location]);
    }

    private function andTheThumbnailShouldBeGenerated()
    {
        $image_stub = m::mock(Image::class);
        $image_stub
            ->shouldReceive('widen')
            ->atLeast()->times(1)
            ->with(GenerateUploads::THUMB_SIZE);

        $image_stub
            ->shouldReceive('save')
            ->atLeast()->times(1)
            ->with($this->thumbnails_folder . $this->photo->upload()->filename());

        $this->image_manager = m::mock(ImageManager::class);
        $this->image_manager
            ->shouldReceive('make')
            ->andReturn($image_stub);
    }

    private function thenThePhotoModificationGetPersisted()
    {
        $this->saver_repository
            ->shouldReceive('__invoke')
            ->atLeast()->times(1);
    }

    private function whenExecutingTheListener()
    {
        $listener = new GenerateUploads(
            $this->file_handler,
            $this->image_manager,
            $this->saver_repository,
            $this->uploads_folder,
            $this->thumbnails_folder
        );

        return $listener->handle($this->event);
    }
}
