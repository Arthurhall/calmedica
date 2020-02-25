<?php

namespace App\Client;

use App\Client\Behavior\ClientSmsSenderInterface;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class IsendProClient extends Client implements ClientSmsSenderInterface
{
    /**
     * @param string $queryString
     *
     * @return ResponseInterface
     */
    public function sendSms(string $queryString): ResponseInterface
    {
        return $this->get(sprintf('cgi-bin/?%s', $queryString));
    }
}
