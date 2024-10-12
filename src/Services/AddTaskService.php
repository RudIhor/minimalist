<?php

declare(strict_types=1);

namespace App\Services;

use App\Actions\Task\CreateTaskAction;
use App\DataTransferObjects\ReplyMarkups\ForceReplyDTO;
use App\Enums\Emoji;
use App\Enums\TaskLimit;
use App\Factories\ViewTasksMessage\DefaultViewMessage;
use App\Models\Task;
use App\Models\TemporaryLog;
use App\Models\User;
use App\Services\ViewServices\ViewTasksService;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Container\ContainerInterface;

class AddTaskService extends AbstractService
{
    protected ViewTasksService $viewTasksService;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->viewTasksService = new ViewTasksService($container);
    }

    /**
     * @param Carbon $date
     * @param int $chatId
     * @return void
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function run(Carbon $date, int $chatId): void
    {
        // TODO: move $_SESSION['chat_id'] class and use DI
        parent::run($date, $chatId);
        $chatId = $_SESSION['chat_id'];
        $locale = User::byChatId($chatId)->first()->language_code;

        if ($this->isUserExceededDailyLimit($date)) {
            $this->telegramService->sendMessage(
                $this->translator->trans(
                    'validation.errors.business.user-exceeded-daily-limit',
                    locale: $locale,
                ),
                $chatId,
            );

            return;
        }

        $data = $this->telegramService->sendMessage(
            $this->translator->trans('ask-task-title', locale: $locale),
            $chatId,
            ForceReplyDTO::make(true)
        );
        TemporaryLog::updateOrCreate([
            'chat_id' => $chatId,
        ], [
            'data' => ['message_id_of_bot_question' => $data['result']['message_id']],
        ]);
    }

    /**
     * @param TemporaryLog $log
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     * @throws \DateMalformedStringException
     */
    public function save(TemporaryLog $log): void
    {
        $_SESSION['message_id'] = $log->data['message_id'];
        $taskDate = $log->date;
        // very unclearly what's happening here
        // TODO: extract it to method with the clear name
        if ($taskDate->isYesterday()) {
            $log->date = Carbon::today()->toDateTimeString();
        }
        (new CreateTaskAction())->handle([
            'title' => $log->data['title'],
            'date' => $log->date,
            'chat_id' => $log->chat_id,
            'emoji' => Emoji::getRandomEmoji(),
        ]);

        $tasks = Task::byChatId($_SESSION['chat_id'])->byDate($taskDate)->get();
        $viewMessage = new DefaultViewMessage($taskDate, $this->translator, $this->hashService);
        $this->viewTasksService->editSentMessage(
            $log->data['message_id'],
            $_SESSION['chat_id'],
            $viewMessage->getText($tasks),
            $taskDate
        );

        $this->telegramService->deleteMessages($_SESSION['chat_id'], [
            $log->data['message_id_of_bot_question'],
            $log->data['message_id_of_user_answer'],
        ]);
    }

    private function isUserExceededDailyLimit(Carbon $date): bool
    {
        $user = User::byChatId($_SESSION['chat_id'])->first();
        $userTasks = $user->tasks()->byDate($date)->get();

        return count($userTasks) >= TaskLimit::getLimit();
    }
}
