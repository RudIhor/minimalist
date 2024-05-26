<?php

declare(strict_types=1);

namespace App\CustomQueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class TemporaryActionBuilder extends Builder
{
    /**
     * @param int $chatId
     * @return TemporaryActionBuilder
     */
    public function byChatId(int $chatId): TemporaryActionBuilder
    {
        return $this->where('chat_id', $chatId);
    }
}
