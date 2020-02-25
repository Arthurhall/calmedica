<?php

namespace App\Model;

use App\Model\Behavior\MessageSmsInterface;

class MessageSms implements MessageSmsInterface
{
    private $number;

    private $sms;

    public function getNumber()
    {
        return $this->number;
    }

    public function getSms()
    {
        return $this->sms;
    }

    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    public function setSms($sms)
    {
        $this->sms = $sms;

        return $this;
    }


}
