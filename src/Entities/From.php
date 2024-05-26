<?php

declare(strict_types=1);

namespace App\Entities;

readonly class From
{
    protected function __construct(
        public int $id,
        public bool $isBot,
        public string $firstName,
        public string $username
    ) {
    }

    public static function from(array $data): From
    {
        return new self($data['id'], $data['is_bot'], $data['first_name'], $data['username']);
    }
}
