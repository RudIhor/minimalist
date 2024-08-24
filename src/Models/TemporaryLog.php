<?php

declare(strict_types=1);

namespace App\Models;

use App\Casts\CustomDataCast;
use App\CustomEloquentBuilders\CommonBuilder;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $chat_id
 * @property array $data
 * @property string $created_at
 * @property Carbon $date
 * @property string $updated_at
 * @method static CommonBuilder byChatId($value)
 */
class TemporaryLog extends Model
{
    protected $fillable = [
        'chat_id',
        'data',
        'date',
    ];

    protected $casts = [
        'data' => CustomDataCast::class,
        'date' => 'datetime',
    ];

    /**
     * @param $query
     * @return CommonBuilder
     */
    public function newEloquentBuilder($query): CommonBuilder
    {
        return new CommonBuilder($query);
    }

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }
}
