<?php

declare(strict_types=1);

namespace App\Factories\ViewTasksMessage;

use Illuminate\Support\Collection;

class NoTaskFoundViewMessage extends AbstractViewMessageFactory
{
    public function getText(Collection $tasks): string
    {
        return $this->translator->trans('commands.no-tasks', locale: $this->date->getLocale());
    }
}
