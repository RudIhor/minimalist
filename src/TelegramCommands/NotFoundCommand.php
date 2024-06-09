<?php

declare(strict_types=1);

namespace App\TelegramCommands;

use App\Entities\Update;

class NotFoundCommand extends AbstractCommand
{
    /**
     * @param Update $update
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     */
    public function execute(Update $update): void
    {
        $this->telegramService->sendMessage('/help', $update->message->chat->id);
    }
}
