<?php

namespace Booothy\User\Domain\Service\ExternalService\Adapter;

use Google_Client;
use Booothy\User\Domain\Service\ExternalService\Adapter;
use Booothy\User\Domain\Service\ExternalService\Exception\InvalidUser;

final class Google implements Adapter
{
    private $client_id;
    private $client_secret;
    private $client;

    public function __construct($a_client_id, $a_client_secret, Google_Client $a_client)
    {
        $this->client_id     = $a_client_id;
        $this->client_secret = $a_client_secret;
        $this->client        = $a_client;
    }

    public function getUserEmail($id_token)
    {
        $this->client->setClientId($this->client_id);
        $this->client->setClientSecret($this->client_secret);

        $ticket = $this->client->verifyIdToken($id_token);

        if (!$ticket) {
            throw new InvalidUser;
        }

        return $ticket->getAttributes()['payload']['email'];
    }
}