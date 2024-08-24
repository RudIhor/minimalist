<?php

declare(strict_types=1);

namespace App\Services\ViewServices;

use App\Enums\TaskAction;

class ViewCopyTaskService extends ViewDeleteTaskService
{
    public function getAction(): TaskAction
    {
        return TaskAction::Copy;
    }
}
