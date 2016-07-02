<?php

namespace BooothyTest\User\Application\Service\PostResource;

use Mockery as m;
use PHPUnit_Framework_TestCase;
use Booothy\User\Application\Service\PostResource\Request;
use Booothy\User\Application\Service\PostResource\UseCase;
use Booothy\User\Domain\Repository\ResourceSaver;

final class UseCaseTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        $this->request = null;
        $this->repository = null;

        m::close();
    }

    /** @test */
    public function shouldCreateTheNewuser()
    {
        $this->givenARequest();
        $this->andARepository();
        $this->thenTheRepositoryShouldBeUsed();
        $this->whenExecutingTheUseCase();
    }

    private function givenARequest()
    {
        $this->request = new Request('email@example.com');
    }

    private function andARepository()
    {
        $this->repository = m::mock(ResourceSaver::class);
    }

    private function thenTheRepositoryShouldBeUsed()
    {
        $this->repository
            ->shouldReceive('__invoke')
            ->atLeast()->times(1);
    }

    private function whenExecutingTheUseCase()
    {
        $use_case = new UseCase($this->repository);
        return $use_case($this->request);
    }
}
