<?php

declare(strict_types=1);

namespace App\Factories\ViewTasksMessage;

class DefaultViewMessage extends AbstractViewMessageFactory
{
    protected function footer(): string
    {
        return '';
    }
}
