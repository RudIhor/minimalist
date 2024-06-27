<?php

declare(strict_types=1);

namespace App\Services;

use App\Actions\Tasks\CreateTaskAction;
use App\DataTransferObjects\ReplyMarkups\ForceReplyDTO;
use App\Models\TemporaryLog;
use Slim\App;

class AddTaskService extends AbstractService
{
    protected ViewTasksService $viewTasksService;

    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->viewTasksService = new ViewTasksService($app);
    }

    /**
     * @param string $date
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     */
    public function run(string $date): void
    {
        parent::run($date);
        $this->askTitle();
    }

    /**
     * @param TemporaryLog $log
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     */
    public function save(TemporaryLog $log): void
    {
        $task = (new CreateTaskAction())->handle($log);

        $log->delete();

        $this->viewTasksService->run($task->date);
    }

    /**
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     */
    public function askDay(): void
    {
        $this->telegramService->sendMessage(
            "Please specify day on which do you want to create task",
            $_SESSION['chat_id'],
            ForceReplyDTO::make(true)
        );
    }

    /**
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     */
    public function askTitle(): void
    {
        $this->telegramService->sendMessage(
            $this->translator->trans('ask-task-title'),
            $_SESSION['chat_id'],
            ForceReplyDTO::make(true)
        );
    }
}
