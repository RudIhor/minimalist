<?php

declare(strict_types=1);

namespace App\Entities;

readonly class Update
{
    protected function __construct(public int $update_id, public Message $message)
    {
    }

    public static function from(array $data)
    {
        return new self($data['update_id'], Message::from($data['message']));
    }
}
