<?php

declare(strict_types=1);

namespace App\TelegramCommands;

use App\Entities\Update;

class HelpCommand extends AbstractCommand
{
    /**
     * @param Update $update
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     */
    public function execute(Update $update): void
    {
        $this->telegramService->sendMessage(
            $this->translator->trans('commands.help', locale: $update->message->from->languageCode),
            $update->message->chat->id,
        );
    }
}
