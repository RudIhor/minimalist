<?php

declare(strict_types=1);

use App\WebhookController;
use Psr\Http\Message\ResponseInterface;
use Slim\App;
use Slim\Psr7\Request;

return function (App $app) {
    $app->get('/setWebhook', [WebhookController::class, 'setWebhook']);

    $app->get('/test', function (Request $request, ResponseInterface $response) {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
        $telegram = new \Telegram\Bot\Api($dotenv->load()['BOT_TOKEN']);
        dd($telegram->getMe());
    });
};
