<?php

declare(strict_types=1);

namespace App\Services\TelegramServices;

use App\Core\TelegramService;
use InvalidArgumentException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Slim\App;
use Symfony\Contracts\Translation\TranslatorInterface;

abstract class AbstractService
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

    /**
     * Invokes a given method on service.
     *
     * @param int $step
     * @param string $text
     * @param int $chatId
     * @return void
     */
    public function handle(int $step, string $text, int $chatId): void
    {
        match ($step) {
            1 => $this->firstStep($text, $chatId),
            2 => $this->secondStep($text, $chatId),
            3 => $this->thirdStep($text, $chatId),
            default => throw new InvalidArgumentException('Method with step: ' . $step . ' does not exist'),
        };
    }

    public function firstStep(string $text, int $chatId)
    {
    }

    public function secondStep(string $text, int $chatId)
    {
    }

    public function thirdStep(string $text, int $chatId)
    {
    }
}
