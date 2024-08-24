<?php

declare(strict_types=1);

namespace App\CustomEloquentBuilders;

use Illuminate\Database\Eloquent\Builder;

class CommonBuilder extends Builder
{
    public function byChatId(int $chatId): self
    {
        return $this->where('chat_id', $chatId);
    }
}
