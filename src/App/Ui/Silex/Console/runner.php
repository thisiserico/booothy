<?php

use Dotenv\Dotenv;
use Symfony\Component\Console\Input\ArgvInput;

require_once BASE_DIR . 'vendor/autoload.php';

set_time_limit(0);

$dotenv = new Dotenv(__DIR__ . '/../../../../../');
$dotenv->load();

$input = new ArgvInput();
$environment = $input->getParameterOption(['--env', '-e'], 'dev');

define('ENVIRONMENT', $environment);

$app = require __DIR__ . '/../Web/Application.php';
require __DIR__.'/Application.php';

$console->run();
