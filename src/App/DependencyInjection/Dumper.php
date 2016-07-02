<?php

namespace App\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

final class Dumper
{
    const FILENAME = 'definition';

    public static function dump()
    {
        $container = new ContainerBuilder;
        $yml_filename = self::FILENAME . '.yml';
        $php_file_path = __DIR__ . '/Services/' . self::FILENAME . '.php';

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/Services'));
        $loader->setResolver(new LoaderResolver([new PhpFileLoader($container, new FileLocator(__DIR__ . '/Services'))]));
        $loader->load($yml_filename);
        $container->compile();

        $dumper = new PhpDumper($container);
        file_put_contents(
            $php_file_path,
            $dumper->dump(['class' => 'ServiceContainer'])
        );
    }
}
