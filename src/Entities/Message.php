<?php

declare(strict_types=1);

namespace App\Entities;

use App\Exceptions\TelegramException;

readonly class Message
{
    protected function __construct(
        public int $id,
        public User $from,
        public int $date,
        public Chat $chat,
        public string $text,
        public ?ReplyToMessage $replyToMessage = null,
    ) {
    }

    /**
     * @param array|null $data
     * @return Message|null
     * @throws TelegramException
     */
    public static function from(?array $data): ?Message
    {
        if (empty($data)) {
            return null;
        }
        if (empty($data['text'])) {
            throw new TelegramException('exceptions.text');
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
