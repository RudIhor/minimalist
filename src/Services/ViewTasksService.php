<?php

declare(strict_types=1);

namespace App\Services;

use App\DataTransferObjects\ReplyMarkups\InlineKeyboardButtonDTO;
use App\DataTransferObjects\ReplyMarkups\InlineKeyboardMarkupDTO;
use App\Enums\Emoji;
use App\Models\Task;
use Illuminate\Support\Collection;

class ViewTasksService extends AbstractService
{
    /**
     * @param string $date
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     */
    public function run(string $date): void
    {
        $this->telegramService->sendMessage(
            $this->generateText($date),
            $_SESSION['chat_id'],
            InlineKeyboardMarkupDTO::make([
                InlineKeyboardButtonDTO::make('➕ Add Task', callback_data: $date . '/add'),
                InlineKeyboardButtonDTO::make('✅ Complete Task', callback_data: $date . '/complete'),
                [
                    InlineKeyboardButtonDTO::make('🗑️ Delete Task', callback_data: $date . '/delete'),
                ],
            ])
        );
    }

    /**
     * @param string $date
     * @return string
     */
    private function generateText(string $date): string
    {
        $tasks = Task::query()
            ->where('chat_id', $_SESSION['chat_id'])
            ->where('date', $date)
            ->where('is_completed', false)
            ->orderBy('created_at')
            ->get();

        return $this->generateTaskBody($tasks);
    }

    /**
     * @param Collection $tasks
     * @return string
     */
    private function generateTaskBody(Collection $tasks): string
    {
        $body = '';
        if ($tasks->count() === 0) {
            return $this->translator->trans('commands.view.header-no-tasks');
        }
        foreach ($tasks as $index => $task) {
            $body .= $this->generateTaskLine($index, $task);
        }

        return $this->translator->trans('commands.view.header') . $body . $this->getFooter();
    }

    /**
     * @param int $index
     * @param Task $task
     * @return string
     */
    private function generateTaskLine(int $index, Task $task): string
    {
        return sprintf("%s %s \n", Emoji::getEmojiNumberByIndex($index), $task->title);
    }

    private function getFooter(): string
    {
        // TODO: replace with call to an GrowthMindset's API
        return "\n_Excuses make today easy, but they make tomorrow hard. Discipline makes today hard, but it makes tomorrow easy. \n(c) Karl Niilo_";
    }
}
