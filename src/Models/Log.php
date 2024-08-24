<?php

declare(strict_types=1);

namespace App\Models;

use App\Casts\CustomDataCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property array $data
 * @property int $user_id
 * @property string $created_at
 * @property string $updated_at
 */
class Log extends Model
{
    protected $fillable = [
        'data',
        'chat_id',
    ];

    protected $casts = [
        'data' => CustomDataCast::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'chat_id', 'chat_id');
    }
}
