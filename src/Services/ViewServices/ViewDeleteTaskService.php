<?php

declare(strict_types=1);

namespace App\Services\ViewServices;

use App\Enums\TaskAction;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ViewDeleteTaskService extends AbstractViewManageService
{
    public function getUserTasks(Carbon $date, int $chatId): Collection
    {
        return Task::byChatId($chatId)->byDate($date)->get();
    }

    public function getAction(): TaskAction
    {
        return TaskAction::Delete;
    }
}
