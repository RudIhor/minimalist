<?php

declare(strict_types=1);

namespace App\Actions\Task;

use App\Models\Task;
use App\Services\HashService;

class CreateTaskAction
{
    private HashService $hashService;

    public function __construct()
    {
        $this->hashService = new HashService();
    }

    /**
     * @param array $data
     * @return Task
     */
    public function handle(array $data): Task
    {
        if (!empty($data['emoji'])) {
            $title = $data['title'] . ' ' . $data['emoji'];
        } else {
            $title = $data['title'];
        }

        return Task::query()->create([
            'title' => $this->hashService->encrypt($title),
            'date' => $data['date'],
            'chat_id' => $data['chat_id'],
        ]);
    }
}
