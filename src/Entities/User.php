<?php

declare(strict_types=1);

namespace App\Entities;

readonly class User
{
    protected function __construct(
        public int $id,
        public string $firstName,
        public ?string $lastName,
        public ?string $username,
        public ?string $languageCode,
        public bool $isPremium
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            $data['id'],
            $data['first_name'],
            $data['last_name'] ?? null,
            $data['username'] ?? null,
            $data['language_code'] ?? null,
            $data['is_premium'] ?? false,
        );
    }
}
