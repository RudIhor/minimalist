<?php

declare(strict_types=1);

namespace App\Services\ViewServices;

use App\Enums\TaskAction;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ViewCompleteTaskService extends AbstractViewManageService
{
    public function getUserTasks(Carbon $date, int $chatId): Collection
    {
        $date->locale($_SESSION['locale']);
        return Task::byChatId($chatId)->byDate($date)->notCompletedYet()->get();
    }

    public function getAction(): TaskAction
    {
        return TaskAction::Complete;
    }
}
