<?php

declare(strict_types=1);

namespace App\Factories\ViewTasksMessage;

use Illuminate\Support\Collection;

class DefaultViewMessage extends AbstractViewMessageFactory
{
    protected function footer(Collection $tasks): string
    {
        return '';
    }
}
