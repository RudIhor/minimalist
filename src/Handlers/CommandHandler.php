<?php

declare(strict_types=1);

namespace App\Handlers;

use App\Entities\Update;
use App\TelegramCommands\AbstractCommand;
use App\TelegramCommands\StartCommand;
use Slim\App;

class CommandHandler
{
    public readonly Update $update;
    public array $availableCommands = [
        '/start' => StartCommand::class,
    ];

    public function __construct(public readonly App $app, array $data)
    {
        $this->update = Update::from($data);
    }

    public function handle(): void
    {
        /** @var AbstractCommand $telegramCommand */
        $telegramCommand = new $this->availableCommands[$this->update->message->text]($this->app);
        $telegramCommand->execute($this->update);
    }
}