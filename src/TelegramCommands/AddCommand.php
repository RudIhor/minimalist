<?php

declare(strict_types=1);

namespace App\TelegramCommands;

use App\DataTransferObjects\ReplyMarkups\ForceReplyDTO;
use App\Entities\Update;
use GuzzleHttp\Exception\GuzzleException;

class AddCommand extends AbstractCommand
{
    /**
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function execute(Update $update): void
    {

    }
}
