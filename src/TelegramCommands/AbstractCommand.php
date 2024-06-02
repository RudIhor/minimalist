<?php

declare(strict_types=1);

namespace App\TelegramCommands;

use App\Core\TelegramService;
use App\Entities\Update;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Slim\App;
use Symfony\Contracts\Translation\TranslatorInterface;

abstract class AbstractCommand
{
    protected TelegramService $telegramService;
    protected TranslatorInterface $translator;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(protected App $app)
    {
        $this->telegramService = $this->app->getContainer()->get(TelegramService::class);
        $this->translator = $this->app->getContainer()->get(TranslatorInterface::class);
    }

    abstract public function execute(Update $update);
}
