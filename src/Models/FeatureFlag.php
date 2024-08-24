<?php

declare(strict_types=1);

namespace App\Models;

use App\CustomEloquentBuilders\FeatureFlagBuilder;
use App\CustomEloquentBuilders\TaskBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $value
 * @property string $created_at
 * @property string $updated_at
 * @method static TaskBuilder|Builder byName(string $name)
 */
class FeatureFlag extends Model
{
    protected $fillable = [
        'name',
        'value',
    ];

    public function newEloquentBuilder($query): FeatureFlagBuilder
    {
        return new FeatureFlagBuilder($query);
    }
}
