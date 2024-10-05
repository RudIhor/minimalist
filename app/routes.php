<?php

declare(strict_types=1);

use App\Controllers\RemindersController;
use App\Handlers\WebhookHandler;
use Slim\App;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

return function (App $app) {
    $app->post('/webhook', function (Request $request, Response $response) use ($app) {
        (new WebhookHandler($app, $request->getParsedBody()))->handle();

        $response->getBody()->write('OK');

        return $response;
    });

    $app->get('/reminders/send-morning', [RemindersController::class, 'sendMorningReminders']);
    $app->get('/reminders/send-afternoon', [RemindersController::class, 'sendAfternoonReminders']);
    $app->get('/reminders/send-evening', [RemindersController::class, 'sendEveningReminders']);

    $app->get('/up', function (Request $request, Response $response) {
        $response->getBody()->write('Healthy!');

        return $response;
    });
};
