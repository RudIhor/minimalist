<?php

declare(strict_types=1);

namespace App\Commands;

use Dotenv\Dotenv;
use GuzzleHttp\Client;
use Symfony\Component\Console\Command\Command;

class AbstractCommand extends Command
{
    protected Client $client;

    public function __construct(?string $name = null)
    {
        parent::__construct($name);
        $this->client = new Client([
            'base_uri' => $_ENV['APP_URL'],
        ]);
    }
}
