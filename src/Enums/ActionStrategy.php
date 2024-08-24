<?php

namespace App\Enums;

use App\Services\AbstractService;
use App\Services\AddTaskService;
use App\Services\CompleteTaskService;
use App\Services\CopyTaskToTomorrowService;
use App\Services\DeleteTaskService;
use App\Services\MoveTaskToTomorrowService;
use App\Services\ViewServices\ViewCompleteTaskService;
use App\Services\ViewServices\ViewCopyTaskService;
use App\Services\ViewServices\ViewDeleteTaskService;
use App\Services\ViewServices\ViewMoveTaskService;
use App\Services\ViewServices\ViewTasksService;

enum ActionStrategy: string
{
    case Add = 'add';
    case View = 'view';

    case ViewComplete = 'view-complete';
    case Complete = 'complete';

    case ViewDelete = 'view-delete';
    case Delete = 'delete';

    case ViewMove = 'view-move';
    case Move = 'move';

    case ViewCopy = 'view-copy';
    case Copy = 'copy';

    /**
     * @param string $action
     * @return string
     */
    public static function getServiceClass(string $action): string
    {
        // TODO: can be refactored with Enum::try($action) or Enum::tryFrom($action)
        return match ($action) {
            self::Add->value => AddTaskService::class,
            self::View->value => ViewTasksService::class,
            self::ViewComplete->value => ViewCompleteTaskService::class,
            self::Complete->value => CompleteTaskService::class,
            self::ViewDelete->value => ViewDeleteTaskService::class,
            self::Delete->value => DeleteTaskService::class,
            self::ViewMove->value => ViewMoveTaskService::class,
            self::Move->value => MoveTaskToTomorrowService::class,
            self::ViewCopy->value => ViewCopyTaskService::class,
            self::Copy->value => CopyTaskToTomorrowService::class,
        };
    }
}
