<?php

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Booothy\User\Application\Service\PostResource\Request;

$console
    ->register('booothy:create-user')
    ->setDescription('Creates a new user')
    ->addOption('email', 'e', InputOption::VALUE_REQUIRED, 'New user email')
    ->setCode(function (InputInterface $input, OutputInterface $output) use ($app) {
        $request  = new Request($input->getOption('email'));
        $use_case = $app['container']->get('user.application.service.post_resource');

        $use_case($request);
    })
;