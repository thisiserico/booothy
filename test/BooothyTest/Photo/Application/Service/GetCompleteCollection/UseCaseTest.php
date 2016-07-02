<?php

namespace BooothyTest\Photo\Application\Service\GetCompleteCollection;

use Mockery as m;
use PHPUnit_Framework_TestCase;
use Booothy\Photo\Application\Service\GetCompleteCollection\Request;
use Booothy\Photo\Application\Service\GetCompleteCollection\UseCase;
use Booothy\Photo\Domain\Model\PhotoCollection;
use Booothy\Photo\Domain\Repository\Loader;

final class UseCaseTest extends PHPUnit_Framework_TestCase
{
    const PAGE = 1;
    const PHOTOS_PER_PAGE = 10;

    public function tearDown()
    {
        $this->request = null;
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

        $result = $this->onExecutingTheUseCase();
        $this->assertInstanceOf(PhotoCollection::class, $result);
    }

    private function givenARequest()
    {
        $this->request = new Request(self::PAGE, self::PHOTOS_PER_PAGE);
    }

    private function andARepository()
    {
        $this->repository = m::mock(Loader::class);
    }

    private function thenTheRepositoryShouldBeUsed()
    {
        $this->repository
            ->shouldReceive('__invoke')
            ->with(m::type('int'), m::type('int'))
            ->andReturn(new PhotoCollection);
    }

    private function onExecutingTheUseCase()
    {
        $use_case = new UseCase($this->repository);
        return $use_case($this->request);
    }
}
