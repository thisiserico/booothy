<?php

namespace BooothyTest\Photo\Application\Listener;

use Mockery as m;
use PHPUnit_Framework_TestCase;
use Intervention\Image\ImageManager;
use Intervention\Image\Image;
use League\ColorExtractor\Client;
use League\ColorExtractor\Image as ExtractedImage;
use Booothy\Photo\Application\Listener\ComputeImageDetails;
use Booothy\Photo\Domain\Repository\Saver;
use Booothy\Photo\Domain\Model\Photo;
use Booothy\Photo\Domain\Event\NewPhotoUploaded;
use Booothy\User\Domain\Model\ValueObject\Email;
use BooothyTest\Photo\Application\Listener\ComputeImageDetailsTest;
use org\bovigo\vfs\vfsStream;

final class ComputeImageDetailsTest extends PHPUnit_Framework_TestCase
{
    const HEX_COLOR = '10316437';
    const IMAGE_WIDTH = 24;
    const IMAGE_HEIGHT = 32;
    const TESTING_IMAGE = '/../../../../../web/images/booothy.png';

    public function tearDown()
    {
        $this->image_manager = null;
        $this->saver_repository = null;
        $this->photo = null;
        $this->temporary_location = null;
        $this->event = null;

        m::close();
    }

    /**
     * @test
     */
    public function shouldPersistThePhotoModifications()
    {
        $this->markTestSkipped('Opening the file takes too much!');

        $this->givenAnImageManipulator();
        $this->andASaverRepository();
        $this->andAPhoto();
        $this->andATemporaryLocation();
        $this->havingANewPhotoUploadedEvent();
        $this->thenThePhotoModificationGetPersisted();
        $this->whenExecutingTheListener();
    }

    /**
     * @test
     */
    public function shouldComputeTheImageDetails()
    {
        $this->markTestSkipped('Opening the file takes too much!');

        $this->givenAnImageManipulator();
        $this->andASaverRepository();
        $this->andAPhoto();
        $this->andATemporaryLocation();
        $this->havingANewPhotoUploadedEvent();
        $this->thenTheImageDetailsGetComputed();
        $this->whenExecutingTheListener();

        $image_details = $this->photo->imageDetails();
        $this->assertEquals(self::HEX_COLOR, $image_details->hexColor());
        $this->assertEquals(self::IMAGE_WIDTH, $image_details->width());
        $this->assertEquals(self::IMAGE_HEIGHT, $image_details->height());
    }

    private function givenAnImageManipulator()
    {
        $this->image_stub = m::mock(Image::class);
        $this->image_stub->shouldReceive('width')->byDefault();
        $this->image_stub->shouldReceive('height')->byDefault();

        $this->image_manager = m::mock(ImageManager::class);
        $this->image_manager
            ->shouldReceive('make')
            ->andReturn($this->image_stub)
            ->byDefault();
    }

    private function andATemporaryLocation()
    {
        $fileSystem = vfsStream::setup();

        $this->temporary_location = vfsStream::newFile('tmp/file')
            ->withContent(file_get_contents(__DIR__.self::TESTING_IMAGE))
            ->at($fileSystem)
            ->url();
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

    private function havingANewPhotoUploadedEvent()
    {
        $this->event = new NewPhotoUploaded(
            $this->photo,
            $this->temporary_location
        );
    }

    private function thenTheImageDetailsGetComputed()
    {
        $extracted_image_stub = m::mock(ExtractedImage::class);
        $extracted_image_stub->shouldReceive('extract')->andReturn([self::HEX_COLOR]);

        $loaded_image_stub = m::mock(Image::class);
        $loaded_image_stub->shouldReceive('width')->andReturn(self::IMAGE_WIDTH);
        $loaded_image_stub->shouldReceive('height')->andReturn(self::IMAGE_HEIGHT);

        $this->image_manager = m::mock(ImageManager::class);
        $this->image_manager->shouldReceive('make')->andReturn($loaded_image_stub);
    }

    private function thenThePhotoModificationGetPersisted()
    {
        $this->saver_repository
            ->shouldReceive('__invoke')
            ->atLeast()->times(1);
    }

    private function whenExecutingTheListener()
    {
        $listener = new ComputeImageDetails(
            $this->image_manager,
            $this->saver_repository
        );

        $listener->handle($this->event);
    }
}
