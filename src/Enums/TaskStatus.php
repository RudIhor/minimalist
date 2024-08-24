<?php

declare(strict_types=1);

namespace App\Enums;

enum TaskStatus: int
{
    case Completed = 1;
    case NotCompleted = 0;
}
