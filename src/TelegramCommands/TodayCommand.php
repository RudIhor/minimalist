<?php

declare(strict_types=1);

namespace App\TelegramCommands;

use App\DataTransferObjects\ReplyMarkups\InlineKeyboardButtonDTO;
use App\DataTransferObjects\ReplyMarkups\InlineKeyboardMarkupDTO;
use App\Entities\Update;
use Carbon\Carbon;
use DateTimeInterface;

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
        $date = Carbon::now()->today()->format(DateTimeInterface::ATOM);

        $this->telegramService->sendMessage(
            $this->translator->trans('commands.today'),
            $update->message->chat->id,
            InlineKeyboardMarkupDTO::make([
                InlineKeyboardButtonDTO::make('➕ Add Task', callback_data: $date . '/add'),
                InlineKeyboardButtonDTO::make('✅ Complete Task', callback_data: $date . '/complete'),
                [
                    InlineKeyboardButtonDTO::make('🗑️ Delete Task', callback_data: $date . '/delete'),
                    InlineKeyboardButtonDTO::make('👀 View Tasks', callback_data: $date . '/view'),
                ],
            ])
        );
    }
}
