<?php

declare(strict_types=1);

namespace App\Models;

use App\CustomQueryBuilders\TemporaryActionBuilder;
use App\CustomQueryBuilders\UserBuilder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $username
 * @property string $language_code
 * @property int $is_premium
 * @property int $chat_id
 * @method static UserBuilder byChatId($value)
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

    /**
     * @param $query
     * @return UserBuilder
     */
    public function newEloquentBuilder($query): UserBuilder
    {
        return new UserBuilder($query);
    }
}
