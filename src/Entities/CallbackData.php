<?php

declare(strict_types=1);

namespace App\Entities;

readonly class CallbackData
{
    public function __construct(public string $value)
    {
    }

    public static function from(int $unix, string $keyword, int|string $value): CallbackData
    {
        return new self($unix . "/" . $keyword . "/" . $value);
    }
}
