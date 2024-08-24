<?php

declare(strict_types=1);

namespace App\Models;

use App\CustomEloquentBuilders\CommonBuilder;
use App\CustomEloquentBuilders\TaskBuilder;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $title
 * @property Carbon $date
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property string $completed_at
 * @property int $index
 * @property int $chat_id
 * @property bool is_completed
 * @method CommonBuilder byChatId($chatId)
 * @method static TaskBuilder byDate($date)
 * @method static TaskBuilder notCompletedYet()
 * @method static TaskBuilder completed()
 */
class Task extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'chat_id',
        'date',
        'index',
        'is_completed',
        'completed_at',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function newEloquentBuilder($query): TaskBuilder
    {
        return new TaskBuilder($query);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'chat_id', 'chat_id');
    }
}
