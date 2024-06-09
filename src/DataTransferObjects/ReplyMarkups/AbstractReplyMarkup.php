<?php

declare(strict_types=1);

namespace App\DataTransferObjects\ReplyMarkups;

interface AbstractReplyMarkup
{
    public function toArray(): array;
}
