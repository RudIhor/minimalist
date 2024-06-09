<?php

declare(strict_types=1);

namespace App\CustomQueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class UserBuilder extends Builder
{
    /**
     * @param int $chatId
     * @return UserBuilder
     */
    public function byChatId(int $chatId): UserBuilder
    {
        return $this->where('chat_id', $chatId);
    }
}
