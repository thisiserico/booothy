<?php

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputOption;

$console = new Application('Booothy console runner', '0.1');

$console->getDefinition()->addOption(new InputOption(
    '--env',
    null,
    InputOption::VALUE_REQUIRED,
    'The Environment name.',
    'dev'
));

$console->setDispatcher($app['dispatcher']);

// Commands
// App
require __DIR__ . '/Command/App/DumpServices.php';
require __DIR__ . '/Command/App/CreateUser.php';

return $console;