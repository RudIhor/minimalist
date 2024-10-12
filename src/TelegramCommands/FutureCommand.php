<?php

declare(strict_types=1);

namespace App\TelegramCommands;

use App\DataTransferObjects\ReplyMarkups\ForceReplyDTO;
use App\Entities\Update;
use App\Models\TemporaryLog;

class FutureCommand extends AbstractCommand
{
    /**
     * @param Update $update
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     */
    public function execute(Update $update): void
    {
        $result = $this->telegramService->sendMessage(
            $this->translator->trans('ask-future-date-for-tasks', locale: $_SESSION['locale']),
            $update->message->chat->id,
            ForceReplyDTO::make(true)
        );

        TemporaryLog::updateOrCreate([
            'chat_id' => $_SESSION['chat_id'],
        ], [
            'data' => ['message_id_of_bot_question' => $result['result']['message_id']],
        ]);
    }
}
