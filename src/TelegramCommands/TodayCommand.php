<?php

declare(strict_types=1);

namespace App\TelegramCommands;

use App\DataTransferObjects\ReplyMarkups\InlineKeyboardButtonDTO;
use App\DataTransferObjects\ReplyMarkups\InlineKeyboardMarkupDTO;
use App\Entities\Update;

class TodayCommand extends AbstractCommand
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
            "📅 *Today's Tasks*\n\nHere you can manage all your tasks for today\. Use the buttons below to quickly add, complete, view, or delete your tasks\.",
            $update->message->chat->id,
            InlineKeyboardMarkupDTO::make([
                InlineKeyboardButtonDTO::make('➕ Add Task', callback_data: 'add-task-for-today'),
                InlineKeyboardButtonDTO::make('✅ Complete Task', callback_data: '1'),
                [
                    InlineKeyboardButtonDTO::make('🗑️ Delete Task', callback_data: '2'),
                    InlineKeyboardButtonDTO::make('👀 View Tasks', callback_data: '3'),
                ],
            ])
        );
    }
}
