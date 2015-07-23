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

final class GenerateUploadsTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        $this->file_handler       = null;
        $this->image_manager      = null;
        $this->saver_repository   = null;
        $this->photo              = null;
        $this->temporary_location = null;
        $this->event              = null;

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
        $modified_photo = $this->whenExecutingTheListener();

        $this->assertEquals(
            Upload::BOOOTHY,
            $modified_photo->upload()->provider()
        );
    }

    private function givenAFileHandler()
    {
        $this->file_handler = m::mock(Filesystem::class);
        $this->file_handler->shouldReceive('mkdir')->byDefault();
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
        $this->photo = Photo::generateNew('quote', 'image/png');
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

    private function thenTheFileHandlerShouldMoveTheFile()
    {
        $this->file_handler
            ->shouldReceive('copy')
            ->atLeast()->times(1)
            ->with(
                $this->temporary_location,
                BASE_DIR . 'var/uploads/' . $this->photo->upload()->filename()
            );

        $this->file_handler
            ->shouldReceive('remove')
            ->atLeast()->times(1)
            ->with([$this->temporary_location]);
    }

    private function andTheThumbnailShouldBeGenerated()
    {
        $this->file_handler
            ->shouldReceive('mkdir')
            ->atLeast()->times(1)
            ->with(BASE_DIR . 'var/uploads/thumbs');

        $image_stub = m::mock(Image::class);
        $image_stub
            ->shouldReceive('widen')
            ->atLeast()->times(1)
            ->with(GenerateUploads::THUMB_SIZE);

        $image_stub
            ->shouldReceive('save')
            ->atLeast()->times(1)
            ->with(BASE_DIR . 'var/uploads/thumbs/' . $this->photo->upload()->filename());

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
            $this->saver_repository
        );

        return $listener->handle($this->event);
    }
}