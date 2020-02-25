<?php

namespace App\Client\Behavior;

interface ClientSmsSenderInterface
{
    public function sendSms(string $queryString);
}
