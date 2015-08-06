<?php

namespace BooothySpec;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Behat\Gherkin\Node\PyStringNode;
use PHPUnit_Framework_Assert as PHPUnit;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Booothy\User\Domain\Model\User;

class BooothyContext implements Context
{
    protected static $app;
    protected $response;

    /** @BeforeSuite */
    public static function loadServiceContainer()
    {
        $file_name = 'definition_test.php';
        $file_path = 'src/App/DependencyInjection/Services/' . $file_name;
        require_once $file_path;

        $class_name        = 'TestServiceContainer';
        $service_container = new $class_name;

        $app = new Application();
        require 'src/App/Ui/Silex/Web/Controllers.php';
        $app['container'] = $service_container;

        self::$app = $app;
    }

    /** @AfterScenario */
    public function resetRequestFlow()
    {
        $this->request  = null;
        $this->response = null;
    }

    /** @Given /^the list with the allowed users:$/ */
    public function listWithTheAllowedUsers(TableNode $allowed_users)
    {
        foreach ($allowed_users as $allowed_user) {
            self::$app['container']
                ->get('user.domain.repository.resource_saver')
                ->__invoke(User::generate($allowed_user['id']));
        }
    }

    /** @When /^I send a ([A-Z]+) request to '([^']+)'$/ */
    public function sendHttpRequestToUri($http_method, $uri)
    {
        $this->request  = Request::create($uri, $http_method);
        $this->response = self::$app->handle($this->request);

        self::$app->terminate($this->request, $this->response);
    }

    /** @When /^I send a ([A-Z]+) request to '([^']+)' with parameters$/ */
    public function sendHttpRequestToUriWithParameters($http_method, $uri, TableNode $raw_parameters)
    {
        $parameters = [];
        foreach ($raw_parameters as $raw_parameter) {
            $parameters[$raw_parameter['attribute']] = $raw_parameter['value'];
        }

        $this->request  = Request::create($uri, $http_method, $parameters);
        $this->response = self::$app->handle($this->request);

        self::$app->terminate($this->request, $this->response);
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