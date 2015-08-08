<?php

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

$console
    ->register('booothy:create-user')
    ->setDescription('Creates a new user')
    ->addOption('email', 'e', InputOption::VALUE_REQUIRED, 'New user email')
    ->setCode(function (InputInterface $input, OutputInterface $output) use ($app) {
        $email = $input->getOption('email');
    })
;