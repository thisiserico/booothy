<?php

namespace BooothyTest\User\Application\Service\GetResource;

use Mockery as m;
use PHPUnit_Framework_TestCase;
use Booothy\User\Application\Service\GetResource\Request;
use Booothy\User\Application\Service\GetResource\UseCase;
use Booothy\User\Domain\Model\User;
use Booothy\User\Domain\Model\ValueObject\Email;
use Booothy\User\Domain\Repository\Exception\NonExistingResource;
use Booothy\User\Domain\Repository\ResourceLoader;

final class UseCaseTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        $this->request    = null;
        $this->repository = null;

        m::close();
    }

    /** @test */
    public function shouldLoadTheRequestedResource()
    {
        $this->givenARequest();
        $this->andARepository();
        $this->thenTheRepositoryShouldBeUsed();
        $this->whenExecutingTheUseCase();
    }

    /** @test */
    public function shouldReturnTheObtainedResource()
    {
        $this->givenARequest();
        $this->andARepository();
        $this->thenTheRepositoryShouldBeUsed();

        $result = $this->whenExecutingTheUseCase();
        $this->assertInstanceOf(User::class, $result);
    }

    /** @test */
    public function shouldFailWhenTheRequestedResourceDoesntExist()
    {
        $this->givenARequest();
        $this->andARepository();
        $this->thenTheRequestedResourceMightNotExist();

        $this->setExpectedException(NonExistingResource::class);
        $this->whenExecutingTheUseCase();
    }

    private function givenARequest()
    {
        $this->request = new Request('email@example.com');
    }

    private function andARepository()
    {
        $this->repository = m::mock(ResourceLoader::class);
    }

    private function thenTheRepositoryShouldBeUsed()
    {
        $this->repository
            ->shouldReceive('__invoke')
            ->andReturn(new User(new Email('email@example.com')));
    }

    private function thenTheRequestedResourceMightNotExist()
    {
        $this->repository
            ->shouldReceive('__invoke')
            ->andThrow(new NonExistingResource);
    }

    private function whenExecutingTheUseCase()
    {
        $use_case = new UseCase($this->repository);
        return $use_case($this->request);
    }
}