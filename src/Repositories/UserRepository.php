<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\JoinClause;

class UserRepository
{
    /**
     * @param Carbon $date
     * @return Collection
     */
    public static function getChatIdThatHasTasksForDate(Carbon $date): Collection
    {
        return User::query()->join('tasks AS t', function (JoinClause $join) use ($date) {
            $join->on('t.chat_id', '=', 'users.chat_id')->where('t.date', $date);
        })->select(['t.chat_id'])->groupBy('t.chat_id')->get();
    }
}
