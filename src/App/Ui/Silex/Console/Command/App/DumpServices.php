<?php

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use App\DependencyInjection\Dumper;

$console
    ->register('app:dump-services')
    ->setDescription('Dump the compiled services files into the DIC')
    ->setDefinition([
        new InputArgument('environments', InputArgument::IS_ARRAY, 'Environments'),
    ])
    ->setCode(function (InputInterface $input, OutputInterface $output) use ($app) {
        $arguments = $input->getArgument('environments');
        Dumper::dump($arguments);
    })
;