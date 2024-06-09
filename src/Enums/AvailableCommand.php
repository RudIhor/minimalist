<?php

declare(strict_types=1);

namespace App\Enums;

use App\TelegramCommands\AddCommand;
use App\TelegramCommands\FutureCommand;
use App\TelegramCommands\HelpCommand;
use App\TelegramCommands\StartCommand;
use App\TelegramCommands\TodayCommand;
use App\TelegramCommands\TomorrowCommand;

enum AvailableCommand: string
{
    public static function all(): array
    {
        return [
            '/start' => StartCommand::class,
            '/help' => HelpCommand::class,
            '/today' => TodayCommand::class,
            '/tomorrow' => TomorrowCommand::class,
            '/future' => FutureCommand::class,
        ];
    }

    public static function registeredCommands(): array
    {
        return [
            [
                'command' => '/help',
                'description' => 'All commands',
            ],
            [
                'command' => '/today',
                'description' => 'Today | Hoy | Сьогодні | Сегодня',
            ],
            [
                'command' => '/tomorrow',
                'description' => 'Tomorrow | Mañana | Завтра | Завтра',
            ],
            [
                'command' => '/future',
                'description' => 'Future | Futura | Майбутнє | Будущее'
            ],
        ];
    }
}
