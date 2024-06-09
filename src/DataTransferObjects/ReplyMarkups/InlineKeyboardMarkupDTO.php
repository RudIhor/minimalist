<?php

declare(strict_types=1);

namespace App\DataTransferObjects\ReplyMarkups;

use ReflectionException;

/**
 * @property InlineKeyboardButtonDTO[] $inline_keyboard
 */
class InlineKeyboardMarkupDTO implements AbstractReplyMarkup
{
    public function __construct(public array $inline_keyboard = [])
    {
    }

    public static function make(array $inline_keyboard): InlineKeyboardMarkupDTO
    {
        return new self($inline_keyboard);
    }

    /**
     * @return array[]
     */
    public function toArray(): array
    {
        $data = [];
        $temp = [];
        foreach ($this->inline_keyboard as $item) {
            if ($item instanceof InlineKeyboardButtonDTO) {
                $keyboardButtonData = [];
                $this->extractKeyboardButtonProperties($item, $keyboardButtonData);
                $temp[] = $keyboardButtonData;
            } else {
                foreach ($item as $keyboardButton) {
                    $keyboardButtonData = [];
                    $this->extractKeyboardButtonProperties($keyboardButton, $keyboardButtonData);
                    $data[][] = $keyboardButtonData;
                }
            }
        }
        if (!empty($temp)) {
            $data[] = $temp;
        }
        usort($data, function($a, $b){
            return count($a) < count($b) ? 1 : 0;
        });

        return ['inline_keyboard' => $data];
    }

    /**
     * @param InlineKeyboardButtonDTO $keyboardButton
     * @param $keyboardButtonData
     * @return void
     */
    private function extractKeyboardButtonProperties(InlineKeyboardButtonDTO $keyboardButton, &$keyboardButtonData): void
    {
        $reflection = new \ReflectionClass($keyboardButton);
        foreach ($reflection->getProperties() as $reflectionProperty) {
            if (!empty($value = $keyboardButton->{$reflectionProperty->name})) {
                $keyboardButtonData[$reflectionProperty->name] = $value;
            }
        }
    }
}
