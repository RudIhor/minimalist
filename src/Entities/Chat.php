<?php

declare(strict_types=1);

namespace App\Entities;

readonly class Chat
{
    protected function __construct(public int $id, public string $type)
    {
    }

    public static function from(array $data): self
    {
        return new self($data['id'], $data['type']);
    }
}
