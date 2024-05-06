<?php

declare(strict_types=1);

namespace App\Commands;

use Dotenv\Dotenv;
use Symfony\Component\Console\Command\Command;

class AbstractCommand extends Command
{
    public function __construct(?string $name = null)
    {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
        $dotenv->load();
        parent::__construct($name);
    }
}
