<?php

declare(strict_types=1);

namespace App\Models;

use App\CustomQueryBuilders\TaskBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * @property string $title
 * @property string $date
 * @property string $created_at
 * @property string $updated_at
 * @method static Builder|Task byDate($date)
 */
class Task extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'chat_id',
        'date',
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
