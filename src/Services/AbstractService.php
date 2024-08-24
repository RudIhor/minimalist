<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\TelegramService;
use App\Models\TemporaryLog;
use Carbon\Carbon;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

abstract class AbstractService
{
    protected TelegramService $telegramService;
    protected TranslatorInterface $translator;
    protected HashService $hashService;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(protected ContainerInterface $container)
    {
        $this->telegramService = $container->get(TelegramService::class);
        $this->translator = $container->get(TranslatorInterface::class);
        $this->hashService = $container->get(HashService::class);
    }

    /**
     * @param string $date
     * @return void
     */
    public function run(Carbon $date, int $chatId): void
    {
        // TODO: move to CreateTemporaryActionAction
        TemporaryLog::updateOrCreate([
            'chat_id' => $chatId,
        ], [
            'date' => $date,
            'data' => ['message_id' => $_SESSION['message_id']],
        ]);
    }
}
