<?php

declare(strict_types=1);

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'queue',
        'payload',
        'attempts',
        'available_at',
        'created_at'
    ];

    protected $casts = [
        'payload' => 'array',
        'available_at' => 'datetime',
    ];

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }
}
