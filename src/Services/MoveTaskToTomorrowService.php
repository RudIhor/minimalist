<?php

declare(strict_types=1);

namespace App\Services;

use App\Actions\Task\MoveTaskToTomorrowAction;
use App\Factories\ViewTasksMessage\DefaultViewMessage;
use App\Models\Task;
use App\Models\TemporaryLog;
use App\Services\ViewServices\ViewTasksService;
use Psr\Container\ContainerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class MoveTaskToTomorrowService
{
    protected ViewTasksService $viewTasksService;

    /**
     * @param ContainerInterface $container
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __construct(protected ContainerInterface $container)
    {
        $this->viewTasksService = new ViewTasksService($container);
    }

    /**
     * @param int $id
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function run(int $id): void
    {
        // TODO: DRY
        $log = TemporaryLog::byChatId($_SESSION['chat_id'])->first();
        (new MoveTaskToTomorrowAction())->handle($id);
        $tasks = Task::byChatId($_SESSION['chat_id'])->byDate($log->date)->get();
        $viewMessage = new DefaultViewMessage(
            $log->date,
            $this->container->get(TranslatorInterface::class),
            $this->container->get(HashService::class)
        );

        $this->viewTasksService->editSentMessage(
            $log->data['message_id'],
            $_SESSION['chat_id'],
            $viewMessage->getText($tasks),
            $log->date
        );
    }
}
