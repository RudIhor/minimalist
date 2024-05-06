<?php

declare(strict_types=1);

namespace App\Entities;

readonly class User
{
    protected function __construct(
        public int $id,
        public string $first_name,
        public ?string $last_name,
        public ?string $username,
        public string $language_code,
        public ?bool $is_premium
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            $data['id'],
            $data['first_name'],
            $data['last_name'] ?? null,
            $data['username'] ?? null,
            $data['language_code'],
            $data['is_premium'] ?? null,
        );
    }
}
