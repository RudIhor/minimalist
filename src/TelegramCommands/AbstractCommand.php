<?php

declare(strict_types=1);

namespace App\TelegramCommands;

use App\Entities\Update;
use Slim\App;

abstract class AbstractCommand
{
    public function __construct(protected App $app)
    {
    }

    abstract public function execute(Update $update);
}
