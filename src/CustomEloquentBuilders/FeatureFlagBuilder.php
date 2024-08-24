<?php

declare(strict_types=1);

namespace App\CustomEloquentBuilders;

use Illuminate\Database\Eloquent\Builder;

class FeatureFlagBuilder extends Builder
{
    /**
     * @param string $name
     * @return FeatureFlagBuilder
     */
    public function byName(string $name): FeatureFlagBuilder
    {
        return $this->where('name', $name);
    }
}
