<?php

declare(strict_types=1);

use App\Validators\AddTaskValidator;
use App\Validators\ViewTaskValidator;

return [
    AddTaskValidator::class => [
        'title' => [1, 2, 6]
    ],
    ViewTaskValidator::class => [
        'futureDate' => [3, 4, 5],
    ],
];
