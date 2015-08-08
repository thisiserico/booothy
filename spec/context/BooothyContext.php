<?php

namespace BooothySpec;

use Behat\Behat\Context\Context;
use Silex\Application as WebApplication;
use Symfony\Component\Console\Application as ConsoleApplication;
use TestServiceContainer;

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
        $file_name = 'definition_test.php';
        $file_path = 'src/App/DependencyInjection/Services/' . $file_name;
        require_once $file_path;

        $service_container = new TestServiceContainer;
        $app               = new WebApplication;

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