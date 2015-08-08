<?php

namespace BooothySpec\Core;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use PHPUnit_Framework_Assert as PHPUnit;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use BooothySpec\BooothyContext;

class ConsoleContext implements Context
{
    /** @AfterScenario */
    public function resetRequestFlow()
    {
        $this->output_result = null;
    }

    /** @When /^I execute the '([^']+)' command with options:$/ */
    public function executeCommandWithOptions($command, TableNode $raw_options)
    {
        $options = [$command];
        foreach ($raw_options as $raw_option) {
            $options[$raw_option['option']] = $raw_option['value'];
        }

        $output_interface = new NullOutput;
        $input_interface  = new ArrayInput($options);

        $this->output_result = BooothyContext::$console->run(
            $input_interface,
            $output_interface
        );
    }

    /** @Then /^the command should exit with code (\d+)$/ */
    public function shouldExitWithCode($exit_code)
    {
        PHPUnit::assertEquals($exit_code, $this->output_result);
    }
}