<?php

declare(strict_types=1);

namespace App\Entities;

readonly class Message
{
    protected function __construct(
        public int $message_id,
        public User $from,
        public int $date,
        public Chat $chat,
        public string $text,
    ) {
    }

    public static function from(array $data)
    {
        return new self(
            $data['message_id'],
            User::from($data['from']),
            $data['date'],
            Chat::from($data['chat']),
            $data['text']
        );
    }
}
