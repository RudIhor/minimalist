<?php

declare(strict_types=1);

namespace App\TelegramCommands;

use App\Core\Telegram;
use App\Entities\Update;
use App\Models\User;
use Symfony\Contracts\Translation\TranslatorInterface;

class StartCommand extends AbstractCommand
{
    /**
     * @param Update $update
     * @return void
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function execute(Update $update)
    {
        /** @var Telegram $telegram */
        $telegram = $this->app->getContainer()->get(Telegram::class);
        /** @var TranslatorInterface $translator */
        $translator = $this->app->getContainer()->get(TranslatorInterface::class);
        // Move to action
        User::query()->updateOrCreate([
            'first_name' => $update->message->from->first_name,
            'last_name' => $update->message->from->last_name,
            'username' => $update->message->from->username,
            'language_code' => $update->message->from->language_code,
            'is_premium' => $update->message->from->is_premium,
        ]);

        // Hello and welcome to MinimaList.
        // Todo Lists in Telegram!
        // Give it a shot: /task
//        $this->telegram->sendMessage('*Привіт*', $);
    }
}
