<?php

declare(strict_types=1);

use App\Controllers\WebhookController;
use Slim\App;

return function (App $app) {
    $app->post('/webhook', [WebhookController::class, 'webhook']);
};
