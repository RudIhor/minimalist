<?php

declare(strict_types=1);

namespace App\CustomEloquentBuilders;

use App\Enums\TaskStatus;
use Carbon\Carbon;

class TaskBuilder extends CommonBuilder
{
    public function notCompletedYet(): TaskBuilder
    {
        return $this->where('is_completed', TaskStatus::NotCompleted->value);
    }

    public function completed(): TaskBuilder
    {
        return $this->where('is_completed', TaskStatus::Completed->value);
    }

    public function byDate(Carbon $day): TaskBuilder
    {
        return $this->whereDate('date', $day->format('Y-m-d'));
    }
}
