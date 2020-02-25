<?php

namespace App\Sender;

use App\Client\Behavior\ClientSmsSenderInterface;
use App\Client\IsendProClient;
use App\Exception\ClientSmsSenderNotFoundException;
use App\Formatter\ClientQueryStringFormatter;

class MessageSmsSender
{
    /**
     * @var array|ClientSmsSenderInterface[]
     */
    private $clients;

    /**
     * @var ClientQueryStringFormatter
     */
    private $queryStringFormatter;

    /**
     * @param ClientQueryStringFormatter $queryStringFormatter
     */
    public function __construct(ClientQueryStringFormatter $queryStringFormatter)
    {
        $this->queryStringFormatter = $queryStringFormatter;
    }

    /**
     * @param ClientSmsSenderInterface $client
     */
    public function addClient(ClientSmsSenderInterface $client)
    {
        $this->clients[] = $client;
    }

    /**
     * @param array $messages
     * @param array $context
     */
    public function send(array $messages, array $context)
    {
        $client = $this->handleClient($messages, $context);
        $queryString = $this->queryStringFormatter->format($client, $messages, $context);

        $client->sendSms($queryString);
    }

    /**
     * Messages and context define wich client to use.
     *
     * @param array $messages
     * @param array $context
     *
     * @return ClientSmsSenderInterface Guzzle client sms sender.
     */
    private function handleClient(array $messages, array $context): ClientSmsSenderInterface
    {
        foreach ($this->clients as $client) {
            if (isset($context['keyid']) && $client instanceof IsendProClient) {
                return $client;
            }
        }

        throw new ClientSmsSenderNotFoundException();
    }
}
