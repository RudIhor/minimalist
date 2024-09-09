<?php

declare(strict_types=1);

namespace App\Factories\ViewTasksMessage;

use Illuminate\Support\Collection;

class EveningViewMessage extends AbstractViewMessageFactory
{
    public function getText(Collection $tasks): string
    {
        return $this->translator->trans('reminders.evening', locale: $this->locale);
    }
}
