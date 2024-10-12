<?php

declare(strict_types=1);

namespace App\Validators;

use App\Factories\ViewTasksMessage\DefaultViewMessage;
use App\Models\Task;
use App\Models\TemporaryLog;
use App\Services\HashService;
use App\Services\ViewServices\ViewTasksService;
use Carbon\Carbon;

class ViewTaskValidator extends AbstractValidator
{
    /**
     * @param string $date
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function futureDate(string $date): void
    {
        preg_match_all('/(?<day>\d{2})\.(?<month>\d{2})/', $date, $matches);
        $filteredMatches = array_filter($matches);
        if (empty($filteredMatches)) {
            $this->throwValidationErrorMessage('date-format');

            return;
        }
        $date = Carbon::createMidnightDate(
            Carbon::now()->year,
            current($filteredMatches['month']),
            current($filteredMatches['day'])
        )->locale($_SESSION['locale']);
        if ($date->isPast() || $date->isNextYear()) {
            $this->throwValidationErrorMessage('date-in-past-or-invalid');

            return;
        }
        $tasks = Task::byChatId($_SESSION['chat_id'])->byDate($date)->get();
        $viewMessage = new DefaultViewMessage($date, $this->translator, $this->container->get(HashService::class));

        // TODO: code below repeats many many times in many many places
        $log = TemporaryLog::byChatId($_SESSION['chat_id'])->first();
        $this->telegramService->deleteMessages($_SESSION['chat_id'], [
            $log->data['message_id_of_bot_question'],
            $log->data['message_id_of_user_answer'],
        ]);

        (new ViewTasksService($this->container))->sendNewMessage(
            $_SESSION['chat_id'],
            $viewMessage->getText($tasks),
            $date
        );
    }
}
