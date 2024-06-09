<?php

declare(strict_types=1);

namespace App\Entities;

readonly class ReplyToMessage
{
    protected function __construct(
        public int $messageId,
        public From $from,
        public int $date,
        public string $text
    ) {
    }

    public static function from(array $data): ReplyToMessage
    {
        return new self($data['message_id'], From::from($data['from']), $data['date'], $data['text']);
    }
}
