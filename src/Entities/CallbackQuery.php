<?php

declare(strict_types=1);

namespace App\Entities;

class CallbackQuery
{
    protected function __construct(
        public string $id,
        public From $from,
        public Message $message,
        public string $chatInstance,
        public string $data,
    ) {
    }

    /**
     * @param array $data
     * @return CallbackQuery
     */
    public static function from(?array $data): ?CallbackQuery
    {
        if (empty($data)) {
            return null;
        }

        return new self(
            $data['id'],
            From::from($data['from']),
            Message::from($data['message']),
            $data['chat_instance'],
            $data['data']
        );
    }
}
