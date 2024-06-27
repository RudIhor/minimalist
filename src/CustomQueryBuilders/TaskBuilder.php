<?php

declare(strict_types=1);

namespace App\CustomQueryBuilders;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class TaskBuilder extends Builder
{
    public function byDate(Carbon $day): TaskBuilder
    {
        return $this->whereDate('created_at', $day);
    }
}
