<?php

declare(strict_types=1);

namespace App\Enums;

enum Emoji: string
{
    public const EMOJIS = [
        '💪',
        '👀',
        '✊',
        '💀',
        '👾',
        '💎',
        '💸',
        '💻',
        '📚',
        '❤',
        '️❤',
        '️‍🔥',
        '💙',
        '💬',
        '💲',
        '🖊',
        '💣',
        '⏳',
        '☀',
        '️⭐',
        '️🔥',
        '💦',
        '🌞',
        '🎓',
        '💼',
        '🧠',
    ];

    case Zero = '0️⃣';
    case One = '1️⃣';
    case Two = '2️⃣';
    case Three = '3️⃣';
    case Four = '4️⃣';
    case Five = '5️⃣';
    case Six = '6️⃣';
    case Seven = '7️⃣';
    case Eight = '8️⃣';
    case Nine = '9️⃣';
    case Ten = '🔟';

    public static function getEmojiNumberByIndex(int $index): string
    {
        return [
            self::Zero->value,
            self::One->value,
            self::Two->value,
            self::Three->value,
            self::Four->value,
            self::Five->value,
            self::Six->value,
            self::Seven->value,
            self::Eight->value,
            self::Nine->value,
            self::Ten->value,
            self::One->value . self::One->value,
            self::One->value . self::Two->value,
            self::One->value . self::Three->value,
            self::One->value . self::Four->value,
            self::One->value . self::Five->value,
            self::One->value . self::Six->value,
            self::One->value . self::Seven->value,
            self::One->value . self::Eight->value,
            self::One->value . self::Nine->value,
            self::Two->value . self::Zero->value,
        ][$index];
    }

    public static function getRandomEmoji(): string
    {
        return self::EMOJIS[array_rand(self::EMOJIS)];
    }
}
