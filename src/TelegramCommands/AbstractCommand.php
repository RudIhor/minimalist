<?php

declare(strict_types=1);

namespace App\TelegramCommands;

use App\Core\TelegramService;
use App\Entities\Update;
use App\Services\ViewServices\ViewTasksService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

abstract class AbstractCommand
{
    protected TelegramService $telegramService;
    protected TranslatorInterface $translator;
    protected ViewTasksService $viewTasksService;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(protected ContainerInterface $container)
    {
        $this->telegramService = $this->container->get(TelegramService::class);
        $this->translator = $this->container->get(TranslatorInterface::class);
        $this->viewTasksService = new ViewTasksService($this->container);
    }

    abstract public function execute(Update $update);
}
