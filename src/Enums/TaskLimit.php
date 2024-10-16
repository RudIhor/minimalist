<?php

declare(strict_types=1);

namespace App\Enums;

enum TaskLimit: int
{
    case DefaultUser = 5;
    case PremiumUser = 20;

    public static function getLimit(): int
    {
        return self::PremiumUser->value;
    }
}
