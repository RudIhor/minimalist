<?php

declare(strict_types=1);

namespace App\DataTransferObjects\ReplyMarkups;

class InlineKeyboardButtonDTO
{
    protected function __construct(
        public string $text,
        public ?string $url = null,
        public ?string $callback_data = null,
        public ?bool $pay = null,
        public ?string $switch_inline_query = null,
        public ?string $switch_inline_query_current_chat = null,
    ) {
    }

    /**
     * @param string $text
     * @param string|null $url
     * @param string|null $callback_data
     * @param bool|null $pay
     * @param string|null $switch_inline_query
     * @param string|null $switch_inline_query_current_chat
     * @return InlineKeyboardButtonDTO
     */
    public static function make(
        string $text,
        ?string $url = null,
        ?string $callback_data = null,
        ?bool $pay = null,
        ?string $switch_inline_query = null,
        ?string $switch_inline_query_current_chat = null
    ): InlineKeyboardButtonDTO {
        return new self($text, $url, $callback_data, $pay, $switch_inline_query, $switch_inline_query_current_chat);
    }
}
