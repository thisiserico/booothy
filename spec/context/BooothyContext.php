<?php

namespace BooothySpec;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Behat\Gherkin\Node\PyStringNode;
use Booothy\User\Domain\Model\User;

class BooothyContext implements Context
{
    protected static $service_container;

    /** @BeforeSuite */
    public static function loadServiceContainer()
    {
        $file_name = 'definition_test.php';
        $file_path = 'src/App/DependencyInjection/Services/' . $file_name;
        require_once $file_path;

        $class_name              = 'TestServiceContainer';
        self::$service_container = new $class_name;
    }

    /** @Given /^the list with the allowed users:$/ */
    public function listWithTheAllowedUsers(TableNode $allowed_users)
    {
        foreach ($allowed_users as $allowed_user) {
            self::$service_container
                ->get('user.domain.repository.resource_saver')
                ->__invoke(User::generate($allowed_user['id']));
        }
    }

    /** @When /^I send a ([A-Z]+) request to (.+)$/ */
    public function sendHttpRequestToUri($http_method, $uri)
    {
    }

    /** @Then /^I should obtain a (\d+) status code$/ */
    public function shouldObtainTheStatusCode($http_status_code)
    {
    }

    /** @Then /^the response should be$/ */
    public function theResponseShouldBe(PyStringNode $expected_response)
    {
    }
}