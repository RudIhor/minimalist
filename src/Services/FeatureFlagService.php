<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\FeatureFlag;

class FeatureFlagService
{
    public function isEnabled(string $feature): bool
    {
        $feature = FeatureFlag::byName($feature)->first();
        if (empty($feature)) {
            return false;
        }

        return $this->evaluateRule($feature->value);
    }

    private function evaluateRule(string $value): bool
    {
        return $value === 'true' || $value === '1' || $value === 'on';
    }
}
