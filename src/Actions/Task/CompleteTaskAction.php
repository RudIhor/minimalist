<?php

declare(strict_types=1);

namespace App\Actions\Task;

use App\Enums\TaskStatus;
use App\Models\Task;

class CompleteTaskAction
{
    /**
     * @param array $data
     * @return int
     */
    public function handle(array $data): int
    {
        return Task::query()->where('id', $data['id'])
            ->update(['is_completed' => (bool)TaskStatus::Completed->value]);
    }
}
