<?php

namespace App;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class WebhookController
{
    public function setWebhook(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $response;
    }
}
