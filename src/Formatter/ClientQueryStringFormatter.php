<?php

namespace App\Formatter;

use App\Client\Behavior\ClientSmsSenderInterface;
use App\Client\IsendProClient;

class ClientQueryStringFormatter
{
    /**
     * @param ClientSmsSenderInterface $client
     * @param array $messages
     * @param array $context
     *
     * @return string
     */
    public function format(ClientSmsSenderInterface $client, array $messages, array $context = [])
    {
        if ($client instanceof IsendProClient) {
            $query = [
                sprintf('keyid=%d', $context['keyid'])
            ];
            foreach ($messages as $i => $message) {
                $query[] = sprintf('sms%d=%s&num%d=%s',
                    $i, $message->getSms(),
                    $i, $message->getNumber()
                );
            }

            return implode('&', $query);
        }
    }
}
