<?php

namespace BooothyTest\Core\Application\Service\Marshaller;

use Mockery as m;
use PHPUnit_Framework_TestCase;
use Booothy\Core\Application\Marshaller;
use Booothy\Core\Application\Request;
use Booothy\Core\Application\Service;
use Booothy\Core\Application\Service\Marshaller\UseCase;

final class UseCaseTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        $this->dependant_service = null;
        $this->marshaller = null;
        $this->request = null;

        m::close();
    }

    /** @test */
    public function shouldWrapTheDependantService()
    {
        $this->givenADependantService();
        $this->andAMarshaller();
        $this->andARequest();
        $this->thenTheMarshallerShouldBeUsed();
        $this->onUseCaseExecution();
    }

    /** @test */
    public function shouldPassTheResultThrough()
    {
        $this->givenADependantService();
        $this->andAMarshaller();
        $this->andARequest();
        $this->thenTheMarshallerShouldBeUsed();

        $result = $this->onUseCaseExecution();
        $this->assertInternalType('array', $result);
        $this->assertEmpty($result);
    }

    private function givenADependantService()
    {
        $this->dependant_service = m::mock(Service::class);
        $this->dependant_service->shouldReceive('__invoke')->byDefault();
    }

    private function andAMarshaller()
    {
        $this->marshaller = m::mock(Marshaller::class);
    }

    private function andARequest()
    {
        $this->request = m::mock(Request::class);
    }

    private function thenTheMarshallerShouldBeUsed()
    {
        $this->marshaller
            ->shouldReceive('__invoke')
            ->andReturn([]);
    }

    private function onUseCaseExecution()
    {
        $use_case = new UseCase($this->dependant_service, $this->marshaller);
        return $use_case($this->request);
    }
}
