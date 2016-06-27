<?php

namespace BooothyTest\User\Application\Service\GetCollection;

use Mockery as m;
use PHPUnit_Framework_TestCase;
use Booothy\User\Application\Service\GetCollection\Request;
use Booothy\User\Application\Service\GetCollection\UseCase;
use Booothy\User\Domain\Model\UserCollection;
use Booothy\User\Domain\Repository\CollectionLoader;

final class UseCaseTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        $this->request = null;
        $this->repository = null;

        m::close();
    }

    /** @test */
    public function shouldLoadTheCompleteUsersCollection()
    {
        $this->givenARequest();
        $this->andARepository();
        $this->thenTheRepositoryShouldBeUsed();
        $this->whenExecutingTheUseCase();
    }

    /** @test */
    public function shouldReturnTheObtainedCollection()
    {
        $this->givenARequest();
        $this->andARepository();
        $this->thenTheRepositoryShouldBeUsed();

        $result = $this->whenExecutingTheUseCase();
        $this->assertInstanceOf(UserCollection::class, $result);
    }

    private function givenARequest()
    {
        $this->request = new Request;
    }

    private function andARepository()
    {
        $this->repository = m::mock(CollectionLoader::class);
    }

    private function thenTheRepositoryShouldBeUsed()
    {
        $this->repository
            ->shouldReceive('__invoke')
            ->andReturn(new UserCollection);
    }

    private function whenExecutingTheUseCase()
    {
        $use_case = new UseCase($this->repository);
        return $use_case($this->request);
    }
}
