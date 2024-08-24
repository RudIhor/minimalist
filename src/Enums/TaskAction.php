<?php

declare(strict_types=1);

namespace App\Enums;

enum TaskAction: string
{
    case Complete = 'complete';
    case Delete = 'delete';
    case Move = 'move';
    case Copy = 'copy';
}
