<?php

declare(strict_types=1);

namespace App\Services;

use App\Actions\Task\CompleteTaskAction;
use App\Factories\ViewTasksMessage\DefaultViewMessage;
use App\Models\Task;
use App\Models\TemporaryLog;
use App\Services\ViewServices\ViewTasksService;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class CompleteTaskService
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
     * @param int $chatId
     * @return void
     * @throws GuzzleException
     * @throws \JsonException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function run(int $id, int $chatId): void
    {
        $log = TemporaryLog::byChatId($chatId)->first();
        (new CompleteTaskAction())->handle(['id' => $id]);
        $tasks = Task::byChatId($chatId)->byDate($log->date)->get();
        $viewMessage = new DefaultViewMessage(
            $log->date,
            $this->container->get(TranslatorInterface::class),
            $this->container->get(HashService::class)
        );

        $this->viewTasksService->editSentMessage(
            $log->data['message_id'],
            $chatId,
            $viewMessage->getText($tasks),
            $log->date
        );
    }
}
