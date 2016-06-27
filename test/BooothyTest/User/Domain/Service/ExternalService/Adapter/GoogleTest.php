<?php

namespace BooothyTest\User\Domain\Service\ExternalService\Adapter;

use Mockery as m;
use PHPUnit_Framework_TestCase;
use Google_Client;
use Google_Auth_LoginTicket;
use Booothy\User\Domain\Service\ExternalService\Adapter\Google;
use Booothy\User\Domain\Service\ExternalService\Exception\InvalidUser;

final class GoogleTest extends PHPUnit_Framework_TestCase
{
    const EMAIL = 'email';

    public function tearDown()
    {
        $this->google_client_id = null;
        $this->google_client_secret = null;
        $this->google_client = null;
        $this->id_token = null;

        m::close();
    }

    /** @test */
    public function shouldLoadTheEmail()
    {
        $this->givenAGoogleClientId();
        $this->andAGoogleClientSecret();
        $this->andAGoogleClient();
        $this->havingAnIdToken();
        $this->thenTheEmailWillGetLoad();

        $this->assertEquals(self::EMAIL, $this->whenExecutingTheService());
    }

    /** @test */
    public function shouldDetectInvalidTokens()
    {
        $this->givenAGoogleClientId();
        $this->andAGoogleClientSecret();
        $this->andAGoogleClient();
        $this->havingAnIdToken();
        $this->thenTheGoogleClientWillDetectAnInvalidToken();

        $this->setExpectedException(InvalidUser::class);
        $this->whenExecutingTheService();
    }

    private function givenAGoogleClientId()
    {
        $this->google_client_id = 'client_id';
    }

    private function andAGoogleClientSecret()
    {
        $this->google_client_secret = 'client_secret';
    }

    private function andAGoogleClient()
    {
        $this->google_client = m::mock(Google_Client::class);

        $this->google_client
            ->shouldReceive('setClientId')
            ->atLeast()->times(1)
            ->with($this->google_client_id);

        $this->google_client
            ->shouldReceive('setClientSecret')
            ->atLeast()->times(1)
            ->with($this->google_client_secret);
    }

    private function havingAnIdToken()
    {
        $this->id_token = 'id_token';
    }

    private function thenTheEmailWillGetLoad()
    {
        $ticket_stub = m::mock(Google_Auth_LoginTicket::class);
        $ticket_stub
            ->shouldReceive('getAttributes')
            ->andReturn(['payload' => ['email' => self::EMAIL]]);

        $this->google_client
            ->shouldReceive('verifyIdToken')
            ->atLeast()->times(1)
            ->with($this->id_token)
            ->andReturn($ticket_stub);
    }

    private function thenTheGoogleClientWillDetectAnInvalidToken()
    {
        $this->google_client
            ->shouldReceive('verifyIdToken')
            ->atLeast()->times(1)
            ->with($this->id_token)
            ->andReturn(null);
    }

    private function whenExecutingTheService()
    {
        $service = new Google(
            $this->google_client_id,
            $this->google_client_secret,
            $this->google_client
        );

        return $service->getUserEmail($this->id_token);
    }
}
