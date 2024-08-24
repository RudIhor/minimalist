<?php

declare(strict_types=1);

namespace App\Services\ViewServices;

use App\Enums\TaskAction;

class ViewMoveTaskService extends ViewCompleteTaskService
{
    public function getAction(): TaskAction
    {
        return TaskAction::Move;
    }
}
