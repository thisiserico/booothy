<?php

$container->setParameter('google.client_id', getenv('GOOGLE_CLIENT_ID'));
$container->setParameter('google.client_secret', getenv('GOOGLE_CLIENT_SECRET'));

$container->setParameter('mongo.db', getenv('MONGO_DB'));
$container->setParameter('mongo.server', getenv('MONGO_SERVER'));

$container->setParameter('booothy_url', getenv('BOOOTHY_URL'));
