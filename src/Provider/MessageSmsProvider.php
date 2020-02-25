<?php

namespace App\Provider;

use App\Entity\Campaign;
use App\Factory\MessageSmsModelFactory;
use App\Model\MessageSms;

class MessageSmsProvider
{
    private $factory;

    public function __construct(MessageSmsModelFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param Campaign $campaign
     *
     * @return MessageSms[]
     */
    public function provide(Campaign $campaign): array
    {
        $smsMessages = [];
        foreach ($campaign->getMessages() as $message) {
            $smsMessages[] = $this->factory->create($message);
        }

        return $smsMessages;
    }
}
