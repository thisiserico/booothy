<?php

namespace BooothySpec;

use Behat\Behat\Context\Context;
use Silex\Application;
use TestServiceContainer;

class BooothyContext implements Context
{
    public static $app;

    /** @BeforeSuite */
    public static function loadServiceContainer()
    {
        $file_name = 'definition_test.php';
        $file_path = 'src/App/DependencyInjection/Services/' . $file_name;
        require_once $file_path;

        $service_container = new TestServiceContainer;
        $app               = new Application;

        require 'src/App/Ui/Silex/Web/Controllers.php';
        $app['container'] = $service_container;

        self::$app = $app;
    }

    /** @AfterScenario */
    public static function cleanMemoryDatabaseHandler()
    {
        self::$app['container']
            ->get('core.infrastructure.repository.memory.handler')
            ->clean();
    }
}