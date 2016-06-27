<?php

namespace BooothyTest\User\Application\Service\Authenticate;

use Mockery as m;
use PHPUnit_Framework_TestCase;
use Booothy\User\Application\Service\Authenticate\Exception\DisallowedUser;
use Booothy\User\Application\Service\Authenticate\Request;
use Booothy\User\Application\Service\Authenticate\UseCase;
use Booothy\User\Domain\Model\User;
use Booothy\User\Domain\Model\ValueObject\Email;
use Booothy\User\Domain\Repository\Exception\NonExistingResource;
use Booothy\User\Domain\Repository\ResourceLoader;
use Booothy\User\Domain\Service\ExternalService\Adapter;
use Booothy\User\Domain\Service\ExternalService\Exception\InvalidUser;

final class UseCaseTest extends PHPUnit_Framework_TestCase
{
    const ID_TOKEN = 'id_token';
    const EMAIL = 'email';

    public function tearDown()
    {
        $this->id_token = null;
        $this->adapter = null;
        $this->repository = null;
        $this->request = null;

        m::close();
    }

    /** @test */
    public function shouldGetTheEmailFromTheExternalAdapter()
    {
        $this->givenAnExternalServiceIdToken();
        $this->andAnExternalServiceAdapter();
        $this->andAResourceLoaderRepository();
        $this->havingARequest();
        $this->thenTheUserEmailShouldBeRetrievedFromTheAdapter();
        $this->whenExecutingTheUseCase();
    }

    /** @test */
    public function shouldFailWhenTheIdTokenIsNotValid()
    {
        $this->givenAnExternalServiceIdToken();
        $this->andAnExternalServiceAdapter();
        $this->andAResourceLoaderRepository();
        $this->havingARequest();
        $this->thenTheAdapterMightDisallowTheIdToken();

        $this->setExpectedException(DisallowedUser::class);
        $this->whenExecutingTheUseCase();
    }

    /** @test */
    public function shouldLoadTheUserFromTheRepository()
    {
        $this->givenAnExternalServiceIdToken();
        $this->andAnExternalServiceAdapter();
        $this->andAResourceLoaderRepository();
        $this->havingARequest();
        $this->thenTheRepositoryWillGetTheRequestedUser();
        $this->whenExecutingTheUseCase();
    }


    /** @test */
    public function shouldFailWhenTheRequestedUserDoesntExist()
    {
        $this->givenAnExternalServiceIdToken();
        $this->andAnExternalServiceAdapter();
        $this->andAResourceLoaderRepository();
        $this->havingARequest();
        $this->thenTheRepositoryMightNotExist();

        $this->setExpectedException(DisallowedUser::class);
        $this->whenExecutingTheUseCase();
    }

    /** @test */
    public function shouldLoadTheUser()
    {
        $this->givenAnExternalServiceIdToken();
        $this->andAnExternalServiceAdapter();
        $this->andAResourceLoaderRepository();
        $this->havingARequest();
        $this->thenTheRepositoryWillGetTheRequestedUser();

        $this->assertInstanceOf(User::class, $this->whenExecutingTheUseCase());
    }

    private function givenAnExternalServiceIdToken()
    {
        $this->id_token = self::ID_TOKEN;
    }

    private function andAnExternalServiceAdapter()
    {
        $this->adapter = m::mock(Adapter::class);
        $this->adapter->shouldReceive('getUserEmail')->byDefault();
    }

    private function andAResourceLoaderRepository()
    {
        $this->repository = m::mock(ResourceLoader::class);
        $this->repository->shouldReceive('__invoke')->byDefault();
    }

    private function havingARequest()
    {
        $this->request = new Request($this->id_token);
    }

    private function thenTheUserEmailShouldBeRetrievedFromTheAdapter()
    {
        $this->adapter
            ->shouldReceive('getUserEmail')
            ->with(self::ID_TOKEN)
            ->andReturn(self::EMAIL);
    }

    private function thenTheAdapterMightDisallowTheIdToken()
    {
        $this->adapter
            ->shouldReceive('getUserEmail')
            ->andThrow(new InvalidUser);
    }

    private function thenTheRepositoryWillGetTheRequestedUser()
    {
        $this->repository
            ->shouldReceive('__invoke')
            ->andReturn(new User(new Email(self::EMAIL)));
    }

    private function thenTheRepositoryMightNotExist()
    {
        $this->repository
            ->shouldReceive('__invoke')
            ->andThrow(new NonExistingResource);
    }

    private function whenExecutingTheUseCase()
    {
        $use_case = new UseCase($this->adapter, $this->repository);
        return $use_case($this->request);
    }
}
