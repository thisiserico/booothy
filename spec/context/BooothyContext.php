<?php

namespace BooothySpec;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Behat\Gherkin\Node\PyStringNode;

class BooothyContext implements Context
{
    /**
     * @Given /^the list with the allowed users:$/
     */
    public function listWithTheAllowedUsers(TableNode $allowed_users)
    {
    }

    /**
     * @When /^I send a ([A-Z]+) request to (.+)$/
     */
    public function sendHttpRequestToUri($http_method, $uri)
    {
    }

    /**
     * @Then /^I should obtain a (\d+) status code$/
     */
    public function shouldObtainTheStatusCode($http_status_code)
    {
    }

    /**
     * @Then /^the response should be$/
     */
    public function theResponseShouldBe(PyStringNode $expected_response)
    {
    }
}