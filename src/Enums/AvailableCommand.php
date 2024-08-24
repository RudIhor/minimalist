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
                'command' => '/today',
                'description' => 'Today | Сьогодні | Hoy | Сегодня | Бүгін | Dzisiaj | Heute | Aujourd\'hui',
            ],
            [
                'command' => '/tomorrow',
                'description' => 'Tomorrow | Завтра | Mañana | Завтра | Ертең | Jutro | Morgen | Demain',
            ],
            [
                'command' => '/future',
                'description' => 'Future | Майбутнє | Futura | Будущее | Болашақ | Dzisiaj | Zukunft | Avenir'
            ],
            [
                'command' => '/help',
                'description' => 'Help | Помощь | Ayuda | Допомога | Көмектесіңдер | मदद | Helfen | Aide',
            ],
        ];
    }
}
