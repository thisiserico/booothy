<?php

namespace BooothySpec;

use Behat\Behat\Context\Context;
use Silex\Application as WebApplication;
use Symfony\Component\Console\Application as ConsoleApplication;
use TestingServiceContainer;

class BooothyContext implements Context
{
    public static $app;
    public static $console;

    /** @BeforeSuite */
    public static function loadServiceContainer()
    {
        self::initializeWebApplication();
        self::initializeConsoleApplication();
    }

    /** @AfterScenario */
    public static function cleanMemoryDatabaseHandler()
    {
        self::$app['container']
            ->get('core.infrastructure.repository.memory.handler')
            ->clean();
    }

    private static function initializeWebApplication()
    {
        require_once 'src/App/DependencyInjection/Services/definition_testing.php';

        $service_container = new TestingServiceContainer;
        $app = new WebApplication;

        require 'src/App/Ui/Silex/Web/Controllers.php';
        $app['container'] = $service_container;

        self::$app = $app;
    }

    private static function initializeConsoleApplication()
    {
        $app     = self::$app;
        $console = new ConsoleApplication('Booothy test console runner');
        $console->setAutoExit(false);

        require 'src/App/Ui/Silex/Console/Command/App/CreateUser.php';

        self::$console = $console;
    }
}