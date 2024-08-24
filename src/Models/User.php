<?php

declare(strict_types=1);

namespace App\Models;

use App\CustomEloquentBuilders\CommonBuilder;
use App\CustomEloquentBuilders\UserBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $username
 * @property string $language_code
 * @property int $is_premium
 * @property int $chat_id
 * @property-read Collection $tasks
 * @method static CommonBuilder byChatId(int $value)
 */
class User extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'language_code',
        'is_premium',
        'chat_id',
    ];

    protected $casts = [
        'is_premium' => 'boolean',
    ];

    /**
     * @param $query
     * @return CommonBuilder
     */
    public function newEloquentBuilder($query): CommonBuilder
    {
        return new CommonBuilder($query);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'chat_id', 'chat_id');
    }
}
