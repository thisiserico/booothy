<?php

require_once BASE_DIR . 'vendor/autoload.php';

set_time_limit(0);

use Symfony\Component\Console\Input\ArgvInput;

$input = new ArgvInput();
$env   = $input->getParameterOption(['--env', '-e'], 'dev');

define('ENV', $env);

$app = require __DIR__ . '/../Web/Application.php';
require __DIR__.'/Application.php';

$console->run();