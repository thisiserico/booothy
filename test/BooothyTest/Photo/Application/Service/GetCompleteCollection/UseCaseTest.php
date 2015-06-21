<?php

namespace Booothy\Photo\Application\Service\GetCompleteCollection;

use Mockery as m;
use PHPUnit_Framework_TestCase;
use Booothy\Photo\Application\Service\GetCompleteCollection\Request;
use Booothy\Photo\Application\Service\GetCompleteCollection\Response;
use Booothy\Photo\Application\Service\GetCompleteCollection\UseCase;
use Booothy\Photo\Domain\Model\PhotoCollection;
use Booothy\Photo\Domain\Repository\Loader;

final class UseCaseTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        $this->request    = null;
        $this->repository = null;

        m::close();
    }

    /** @test */
    public function shouldLoadTheCompletePhotosCollection()
    {
        $this->givenARequest();
        $this->andARepository();
        $this->thenTheRepositoryShouldBeUsed();
        $this->onExecutingTheUseCase();
    }

    /** @test */
    public function shouldReturnTheObtainedCollection()
    {
        $this->givenARequest();
        $this->andARepository();
        $this->thenTheRepositoryShouldBeUsed();
        $response = $this->onExecutingTheUseCase();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertInstanceOf(PhotoCollection::class, $response->collection);
    }

    private function givenARequest()
    {
        $this->request = new Request;
    }

    private function andARepository()
    {
        $this->repository = m::mock(Loader::class);
    }

    private function thenTheRepositoryShouldBeUsed()
    {
        $this->repository
            ->shouldReceive('__invoke')
            ->andReturn(new PhotoCollection);
    }

    private function onExecutingTheUseCase()
    {
        $use_case = new UseCase($this->repository);
        return $use_case($this->request);
    }
}