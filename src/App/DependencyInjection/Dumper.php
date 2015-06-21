<?php

namespace App\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class Dumper
{
    const FILENAME = 'definition';

    public static function dump(array $environments)
    {
        foreach ($environments as $environment) {
            self::dumpServicesFor($environment);
        }
    }

    private static function dumpServicesFor($environment)
    {
        $container     = new ContainerBuilder;
        $yml_filename  = self::FILENAME . '_' . $environment . '.yml';
        $php_file_path = __DIR__ . '/Services/' . self::FILENAME . '_' . $environment . '.php';

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/Services'));
        $loader->load($yml_filename);
        $container->compile();

        $dumper = new PhpDumper($container);
        file_put_contents(
            $php_file_path,
            $dumper->dump(['class' => ucfirst($environment) . 'ServiceContainer'])
        );
    }
}