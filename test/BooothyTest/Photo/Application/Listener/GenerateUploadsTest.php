<?php

namespace BooothyTest\Photo\Application\Listener;

use Mockery as m;
use PHPUnit_Framework_TestCase;
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
        $this->saver_repository   = null;
        $this->photo              = null;
        $this->temporary_location = null;
        $this->event              = null;

        m::close();
    }

    /** @test */
    public function shouldMoveTheUploadToTheFinalLocation()
    {
        $this->givenAFileHandler();
        $this->andASaverRepository();
        $this->andAPhoto();
        $this->andATemporaryLocation();
        $this->havingANewPhotoUploadedEvent();
        $this->thenTheFileHandlerShouldMoveTheFile();
        $this->whenExecutingTheListener();
    }

    /** @test */
    public function shouldPersistThePhotoModifications()
    {
        $this->givenAFileHandler();
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
        $this->file_handler->shouldReceive('copy')->byDefault();
        $this->file_handler->shouldReceive('remove')->byDefault();
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
            $this->saver_repository
        );

        return $listener->handle($this->event);
    }
}