<?php

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\DependencyInjection\Dumper;

$console
    ->register('app:dump-services')
    ->setDescription('Dump the compiled services files into the DIC')
    ->setCode(function (InputInterface $input, OutputInterface $output) use ($app) {
        Dumper::dump();
    })
;
