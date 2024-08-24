<?php

declare(strict_types=1);

namespace App\Actions\Log;

use App\Models\Log;

class CreateLogAction
{
    /**
     * @param array $data
     * @return Log
     */
    public function execute(array $data): Log
    {
        return Log::create([
            'data' => $data['data'],
            'chat_id' => $data['chat_id'],
        ]);
    }
}
