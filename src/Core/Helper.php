<?php

declare(strict_types=1);

namespace App\Core;

use Carbon\Carbon;

class Helper
{
    /**
     * @param Carbon $carbon
     * @return int
     */
    public static function convertCarbonToUnix(Carbon $carbon): int
    {
        return $carbon->unix();
    }
}
