<?php

declare(strict_types=1);

namespace App\Core;

use App\DataTransferObjects\ReplyMarkups\InlineKeyboardButtonDTO;
use App\DataTransferObjects\ReplyMarkups\InlineKeyboardMarkupDTO;
use App\Entities\CallbackData;
use App\Enums\ButtonAction;

class ButtonHelper
{
    /**
     * @param int $unix
     * @return InlineKeyboardButtonDTO
     */
    public static function getBackButton(int $unix): InlineKeyboardButtonDTO
    {
        return InlineKeyboardButtonDTO::make(
            '⬅️',
            callback_data: $unix . '/' . ButtonAction::Back->value
        );
    }

    /**
     * @param string $text
     * @param CallbackData $callbackData
     * @return InlineKeyboardButtonDTO
     */
    public static function createCallbackButton(string $text, CallbackData $callbackData): InlineKeyboardButtonDTO
    {
        return InlineKeyboardButtonDTO::make(
            $text,
            callback_data: $callbackData->value
        );
    }

    /**
     * Get buttons for view tasks message
     *
     * @param int $unix
     * @return InlineKeyboardMarkupDTO
     */
    public static function getDefaultButtons(int $unix): InlineKeyboardMarkupDTO
    {
        return InlineKeyboardMarkupDTO::make([
            [
                InlineKeyboardButtonDTO::make('⏩', callback_data: $unix . '/view-move'),
                InlineKeyboardButtonDTO::make('🔂', callback_data: $unix . '/view-copy'),
            ],
            InlineKeyboardButtonDTO::make('➕', callback_data: $unix . '/add'),
            InlineKeyboardButtonDTO::make('✅', callback_data: $unix . '/view-complete'),
            [
                InlineKeyboardButtonDTO::make('🗑️', callback_data: $unix . '/view-delete'),
            ],
        ]);
    }
}
