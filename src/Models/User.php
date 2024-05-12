<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @public int $id
 */
class User extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'language_code',
        'is_premium',
    ];
}
