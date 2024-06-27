<?php

declare(strict_types=1);

namespace App\Validators;

use App\Models\Task;
use Carbon\Carbon;

class CompleteTaskValidator extends AbstractValidator
{
    public function taskNumber(string $text)
    {
        $userTasksCount = Task::byDate(Carbon::today())->count();
//        $numbers = preg_split('/(,)|(, )/', $text);
//        return $numbers;
    }
}
