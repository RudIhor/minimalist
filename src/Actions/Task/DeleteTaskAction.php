<?php

declare(strict_types=1);

namespace App\Actions\Task;

use App\Models\Task;

class DeleteTaskAction
{
    /**
     * @param array $data
     * @return int
     */
    public function handle(array $data): int
    {
         return Task::query()->where('id', $data['id'])->delete();
    }
}
