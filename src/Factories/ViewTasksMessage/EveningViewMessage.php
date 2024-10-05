<?php

declare(strict_types=1);

namespace App\Factories\ViewTasksMessage;

use Illuminate\Support\Collection;

class EveningViewMessage extends AbstractViewMessageFactory
{
    public function footer(Collection $tasks): string
    {
        $completedTasksCount = $tasks->filter(fn($task) => $task->is_completed)->count();
        $uncompletedTasksCount = $tasks->filter(fn($task) => !$task->is_completed)->count();

        return sprintf(
            $this->translator->trans(
                'reminders.evening',
                locale: $this->locale
            ),
            $completedTasksCount,
            $uncompletedTasksCount
        );
    }
}
