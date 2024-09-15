<?php

declare(strict_types=1);

namespace App\Entities;

readonly class Update
{
    protected function __construct(public int $updateId, public ?Message $message, public ?CallbackQuery $callbackQuery)
    {
    }

    /**
     * @param array $data
     * @return Update
     * @throws \App\Exceptions\TelegramException
     */
    public static function from(array $data): Update
    {
        return new self(
            $data['update_id'],
            Message::from($data['message'] ?? null),
            CallbackQuery::from($data['callback_query'] ?? null)
        );
    }
}
