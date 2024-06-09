<?php

declare(strict_types=1);

namespace App\Models;

use App\Casts\CustomDataCast;
use App\CustomQueryBuilders\TemporaryActionBuilder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $chat_id
 * @property array $data
 * @property string $created_at
 * @property string $updated_at
 * @method static TemporaryActionBuilder byChatId($value)
 */
class TemporaryAction extends Model
{
    protected $fillable = [
        'chat_id',
        'data',
    ];

    protected $casts = [
        'data' => CustomDataCast::class,
    ];

    /**
     * @param $query
     * @return TemporaryActionBuilder
     */
    public function newEloquentBuilder($query): TemporaryActionBuilder
    {
        return new TemporaryActionBuilder($query);
    }
}
