<?php

namespace App\Factory;

use App\Entity\Message;
use App\Entity\MessageType;
use App\Model\MessageSms;

class MessageSmsModelFactory
{
    public function create(Message $message): MessageSms
    {
        if ($message->getMessageType()->getName() == MessageType::SMS) {
            $sms = new MessageSms();

            return $sms
                ->setSms($message->getBody())
                ->setNumber($message->getUser()->getPhoneNumber());
        }
    }
}
