<?php

declare(strict_types=1);

namespace App\Entities;

readonly class Message
{
    protected function __construct(
        public int $messageId,
        public User $from,
        public int $date,
        public Chat $chat,
        public string $text,
        public ?ReplyToMessage $replyToMessage = null,
    ) {
    }

    public static function from(?array $data): ?Message
    {
        if (empty($data)) {
            return null;
        }

        return new self(
            $data['message_id'],
            User::from($data['from']),
            $data['date'],
            Chat::from($data['chat']),
            $data['text'],
            !empty($data['reply_to_message']) ? ReplyToMessage::from($data['reply_to_message']) : null,
        );
    }
}
