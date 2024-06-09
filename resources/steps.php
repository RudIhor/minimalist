<?php

declare(strict_types=1);

use App\Services\TelegramServices\AddService;

return [
    AddService::class => [
        "Great\n Let's add a new task to your to do list for today\n What's the name of the task? Example" => 1,
        'Please specify priority of the task from 1 to 3(High to Low)' => 2,
    ],
    # /remove command
    # /markasdone command
];
