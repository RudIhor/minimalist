<?php

declare(strict_types=1);

namespace App\TelegramCommands;

use App\DataTransferObjects\ReplyMarkups\InlineKeyboardButtonDTO;
use App\DataTransferObjects\ReplyMarkups\InlineKeyboardMarkupDTO;
use App\Entities\Update;

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
        $this->telegramService->sendMessage(
            "📅 *Future Tasks*\n\nPlan your tasks for the days ahead\. Use the buttons below to add, complete, view, or delete tasks for any future date\. Keep track of your long term goals and deadlines\!",
            $update->message->chat->id,
            InlineKeyboardMarkupDTO::make([
                InlineKeyboardButtonDTO::make('➕ Add Task', callback_data: 'add-task-for-future'),
                InlineKeyboardButtonDTO::make('✅ Complete Task', callback_data: '1'),
                [
                    InlineKeyboardButtonDTO::make('🗑️ Delete Task', callback_data: '2'),
                    InlineKeyboardButtonDTO::make('👀 View Tasks', callback_data: '3'),
                ],
            ]),
        );
    }
}
