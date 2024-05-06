<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Handlers\CommandHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class WebhookController
{
    public function webhook(ServerRequestInterface $request, ResponseInterface $response)
    {
        (new CommandHandler($request->getParsedBody()))->handle();
    }
}
