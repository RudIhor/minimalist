<?php

declare(strict_types=1);

use App\Handlers\CommandHandler;
use Slim\App;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

return function (App $app) {
    $app->post('/webhook', function (Request $request, Response $response) use ($app) {
        (new CommandHandler($app, $request->getParsedBody()))->handle();

        $response->getBody()->write('OK');

        return $response;
    });
};
