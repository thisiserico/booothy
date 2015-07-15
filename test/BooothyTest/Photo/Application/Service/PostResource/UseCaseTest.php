<?php

namespace BooothyTest\Photo\Application\Service\PostResource;

use Mockery as m;
use PHPUnit_Framework_TestCase;
use League\Event\Emitter;
use Booothy\Photo\Application\Service\PostResource\Request;
use Booothy\Photo\Application\Service\PostResource\UseCase;
use Booothy\Photo\Domain\Event\NewPhotoUploaded;
use Booothy\Photo\Domain\Model\Photo;
use Booothy\Photo\Domain\Repository\Saver;

final class UseCaseTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        $this->quote              = null;
        $this->mime_type          = null;
        $this->temporary_location = null;
        $this->repository         = null;
        $this->event_emitter      = null;
        $this->request            = null;

        m::close();
    }

    /** @test */
    public function shouldSaveTheNewPhoto()
    {
        $this->givenAQuote('some quote');
        $this->andAnUploadMimeType('image/png');
        $this->andAnUploadTemporaryLocation('/tmp/image');
        $this->andARepository();
        $this->andAnEventEmitter();
        $this->havingARequest();
        $this->thenTheNewPhotoShouldBeSaved();
        $this->whenExecutingTheUseCase();
    }

    /** @test */
    public function shouldEmitAnEvent()
    {
        $this->givenAQuote('some quote');
        $this->andAnUploadMimeType('image/png');
        $this->andAnUploadTemporaryLocation('/tmp/image');
        $this->andARepository();
        $this->andAnEventEmitter();
        $this->havingARequest();
        $this->thenANewPhotoCreatedEventShouldBeFired();
        $this->whenExecutingTheUseCase();
    }

    /** @test */
    public function shoulReturnTheNewlyCreatedPhoto()
    {
        $this->givenAQuote('some quote');
        $this->andAnUploadMimeType('image/png');
        $this->andAnUploadTemporaryLocation('/tmp/image');
        $this->andARepository();
        $this->andAnEventEmitter();
        $this->havingARequest();

        $this->assertInstanceOf(
            Photo::class,
            $this->whenExecutingTheUseCase()
        );
    }

    private function givenAQuote($quote)
    {
        $this->quote = $quote;
    }

    private function andAnUploadMimeType($mime_type)
    {
        $this->mime_type = $mime_type;
    }

    private function andAnUploadTemporaryLocation($location)
    {
        $this->temporary_location = $location;
    }

    private function andARepository()
    {
        $this->repository = m::mock(Saver::class);
        $this->repository->shouldReceive('__invoke')->byDefault();
    }

    private function andAnEventEmitter()
    {
        $this->event_emitter = m::mock(Emitter::class);
        $this->event_emitter->shouldReceive('emit')->byDefault();
    }

    private function havingARequest()
    {
        $this->request = new Request(
            $this->quote,
            $this->mime_type,
            $this->temporary_location
        );
    }

    private function thenTheNewPhotoShouldBeSaved()
    {
        $this->repository
            ->shouldReceive('__invoke')
            ->atLeast()->times(1);
    }

    private function thenANewPhotoCreatedEventShouldBeFired()
    {
        $this->event_emitter
            ->shouldReceive('emit')
            ->atLeast()->times(1)
            ->with(m::type(NewPhotoUploaded::class));
    }

    private function whenExecutingTheUseCase()
    {
        $use_case = new UseCase($this->repository, $this->event_emitter);
        return $use_case($this->request);
    }
}