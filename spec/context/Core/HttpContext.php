<?php

namespace BooothySpec\Core;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Behat\Gherkin\Node\PyStringNode;
use PHPUnit_Framework_Assert as PHPUnit;
use Symfony\Component\HttpFoundation\Request;
use BooothySpec\BooothyContext;

class HttpContext implements Context
{
    /** @AfterScenario */
    public function resetRequestFlow()
    {
        $this->request  = null;
        $this->response = null;
    }

    /** @When /^I send a ([A-Z]+) request to '([^']+)'$/ */
    public function sendHttpRequestToUri($http_method, $uri)
    {
        $this->request  = Request::create($uri, $http_method);
        $this->response = BooothyContext::$app->handle($this->request);

        BooothyContext::$app->terminate($this->request, $this->response);
    }

    /** @When /^I send a ([A-Z]+) request to '([^']+)' with a token$/ */
    public function sendHttpRequestToUriWithIdToken($http_method, $uri)
    {
        $parameters     = ['id_token' => 'token'];
        $this->request  = Request::create($uri, $http_method, $parameters);
        $this->response = BooothyContext::$app->handle($this->request);

        BooothyContext::$app->terminate($this->request, $this->response);
    }

    /** @When /^I send a ([A-Z]+) request to '([^']+)' with parameters$/ */
    public function sendHttpRequestToUriWithParameters($http_method, $uri, TableNode $raw_parameters)
    {
        $parameters = [];
        foreach ($raw_parameters as $raw_parameter) {
            $parameters[$raw_parameter['attribute']] = $raw_parameter['value'];
        }

        $this->request  = Request::create($uri, $http_method, $parameters);
        $this->response = BooothyContext::$app->handle($this->request);

        BooothyContext::$app->terminate($this->request, $this->response);
    }

    /** @Then /^I should obtain a (\d+) status code$/ */
    public function shouldObtainTheStatusCode($http_status_code)
    {
        PHPUnit::assertEquals(
            $http_status_code,
            $this->response->getStatusCode()
        );
    }

    /** @Then /^the response should be$/ */
    public function theResponseShouldBe(PyStringNode $expected_response)
    {
        $this->assertEqualJsons(
            $expected_response->getRaw(),
            $this->response->getContent()
        );
    }

    private function assertEqualJsons($expected, $actual, $error_message = '')
    {
        PHPUnit::assertJson($expected, $error_message);
        PHPUnit::assertJson($actual, $error_message);

        $expected = json_decode($expected);
        $actual   = json_decode($actual);

        PHPUnit::assertEquals($expected, $actual, $error_message);
    }
}