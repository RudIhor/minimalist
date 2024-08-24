<?php

declare(strict_types=1);

namespace App\Services\ViewServices;

use App\Core\ButtonHelper;
use App\Models\TemporaryLog;
use App\Services\AbstractService;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;

class ViewTasksService extends AbstractService
{
    /**
     * @param int $chatId
     * @param string $text
     * @param Carbon $date
     * @return void
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function sendNewMessage(int $chatId, string $text, Carbon $date): void
    {
        $messageId = $this->telegramService->loading('_Loading..._', $chatId);

        TemporaryLog::updateOrCreate([
            'chat_id' => $chatId,
        ], [
            'date' => $date,
            'data' => ['message_id' => $messageId, 'previous_message_text' => $text],
        ]);

        $this->telegramService->editSentMessageText(
            $text,
            $chatId,
            $messageId,
            ButtonHelper::getDefaultButtons($date->unix())
        );
    }

    /**
     * @param int $messageId
     * @param int $chatId
     * @param string $text
     * @param Carbon $date
     * @param string|null $updateText
     * @return void
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function editSentMessage(
        int $messageId,
        int $chatId,
        string $text,
        Carbon $date,
        ?string $updateText = null,
    ): void {
        $this->telegramService->editSentMessageText(
            $updateText ?? $text,
            $chatId,
            $messageId,
            ButtonHelper::getDefaultButtons($date->unix())
        );
    }
}
