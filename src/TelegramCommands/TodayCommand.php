<?php

declare(strict_types=1);

namespace App\TelegramCommands;

use App\Entities\Update;
use App\Factories\ViewTasksMessage\DefaultViewMessage;
use App\Models\Task;
use App\Services\HashService;
use Carbon\Carbon;

class TodayCommand extends AbstractCommand
{
    /**
     * @param Update $update
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function execute(Update $update): void
    {
        $date = Carbon::today()->locale($update->message->from->languageCode);
        $tasks = Task::byChatId($update->message->chat->id)->byDate($date)->get();
        $viewMessage = new DefaultViewMessage($date, $this->translator, $this->container->get(HashService::class));

        $this->viewTasksService->sendNewMessage($update->message->chat->id, $viewMessage->getText($tasks), $date);
    }
}
