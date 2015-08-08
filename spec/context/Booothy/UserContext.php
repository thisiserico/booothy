<?php

namespace BooothySpec\Booothy;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Booothy\User\Domain\Model\User;
use Booothy\User\Domain\Model\ValueObject\Email;
use BooothySpec\BooothyContext;

class UserContext implements Context
{
    protected static $app;

    /** @Given /^the list with the allowed users:$/ */
    public function listWithTheAllowedUsers(TableNode $allowed_users)
    {
        foreach ($allowed_users as $allowed_user) {
            BooothyContext::$app['container']
                ->get('user.domain.repository.resource_saver')
                ->__invoke(User::generate($allowed_user['id']));
        }
    }

    /** @Given /^an allowed user$/ */
    public function beingAnAllowedUser()
    {
        BooothyContext::$app['container']
            ->get('user.domain.repository.resource_saver')
            ->__invoke(User::generate('allowed@example.com'));
    }

    /** @Then /the user '([^']+)' should exist/ */
    public function theUserShouldExist($expected_user)
    {
        BooothyContext::$app['container']
            ->get('user.domain.repository.resource_loader')
            ->__invoke(new Email($expected_user));
    }
}