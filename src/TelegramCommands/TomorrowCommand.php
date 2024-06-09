<?php

declare(strict_types=1);

namespace App\TelegramCommands;

use App\DataTransferObjects\ReplyMarkups\InlineKeyboardButtonDTO;
use App\DataTransferObjects\ReplyMarkups\InlineKeyboardMarkupDTO;
use App\Entities\Update;

class TomorrowCommand extends AbstractCommand
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
            "📅 *Tomorrow's Tasks*\n\nGet ready for tomorrow by managing your tasks now\. Use the buttons below to add, complete, view, or delete tasks for tomorrow\. Plan ahead and stay organized\!",
            $update->message->chat->id,
            InlineKeyboardMarkupDTO::make([
                InlineKeyboardButtonDTO::make('➕ Add Task', callback_data: 'add-task-for-tomorrow'),
                InlineKeyboardButtonDTO::make('✅ Complete Task', callback_data: '1'),
                [
                    InlineKeyboardButtonDTO::make('🗑️ Delete Task', callback_data: '2'),
                    InlineKeyboardButtonDTO::make('👀 View Tasks', callback_data: '3'),
                ],
            ])
        );
    }
}
