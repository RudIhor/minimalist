<?php

declare(strict_types=1);

namespace App\Actions\Task;

use App\Enums\Emoji;
use App\Models\Task;
use App\Services\HashService;
use Carbon\Carbon;

class CopyTaskToTomorrowAction
{
    private HashService $hashService;

    public function __construct()
    {
        $this->hashService = new HashService();
    }

    /**
     * @param int $id
     * @return Task
     */
    public function handle(int $id): Task
    {
        $oldTask = Task::query()->find($id);

        return (new CreateTaskAction())->handle([
            'title' => $this->hashService->decrypt($oldTask->title),
            'date' => Carbon::tomorrow(),
            'chat_id' => $oldTask->chat_id,
        ]);
    }
}
