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

final class ComputeImageDetailsTest extends PHPUnit_Framework_TestCase
{
    const HEX_COLOR    = '#hex_color';
    const IMAGE_WIDTH  = 24;
    const IMAGE_HEIGHT = 32;

    public function tearDown()
    {
        $this->hex_color_extractor = null;
        $this->image_manager       = null;
        $this->saver_repository    = null;
        $this->photo               = null;
        $this->temporary_location  = null;
        $this->event               = null;

        m::close();
    }

    /** @test */
    public function shouldPersistThePhotoModifications()
    {
        $this->givenAnHexColorExtractor();
        $this->andAnImageManipulator();
        $this->andASaverRepository();
        $this->andAPhoto();
        $this->andATemporaryLocation();
        $this->havingANewPhotoUploadedEvent();
        $this->thenThePhotoModificationGetPersisted();
        $this->whenExecutingTheListener();
    }

    /** @test */
    public function shouldComputeTheImageDetails()
    {
        $this->givenAnHexColorExtractor();
        $this->andAnImageManipulator();
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

    private function givenAnHexColorExtractor()
    {
        $image_stub = m::mock(ExtractedImage::class);
        $image_stub->shouldReceive('extract')->byDefault();

        $this->hex_color_extractor = m::mock(Client::class);
        $this->hex_color_extractor
            ->shouldReceive('loadPng')
            ->andReturn($image_stub)
            ->byDefault();
    }

    private function andAnImageManipulator()
    {
        $image_stub = m::mock(Image::class);
        $image_stub->shouldReceive('width')->byDefault();
        $image_stub->shouldReceive('height')->byDefault();

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

    private function thenTheImageDetailsGetComputed()
    {
        $extracted_image_stub = m::mock(ExtractedImage::class);
        $extracted_image_stub->shouldReceive('extract')->andReturn([self::HEX_COLOR]);

        $this->hex_color_extractor
            ->shouldReceive('loadPng')
            ->with($this->temporary_location)
            ->andReturn($extracted_image_stub);


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
            $this->hex_color_extractor,
            $this->image_manager,
            $this->saver_repository
        );

        $listener->handle($this->event);
    }
}