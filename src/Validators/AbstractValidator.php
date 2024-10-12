<?php

declare(strict_types=1);

namespace App\Validators;

use App\Core\TelegramService;
use App\DataTransferObjects\ReplyMarkups\ForceReplyDTO;
use App\Models\TemporaryLog;
use Psr\Container\ContainerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

abstract class AbstractValidator
{
    protected TranslatorInterface $translator;
    protected TelegramService $telegramService;

    /**
     * @param ContainerInterface $container
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __construct(protected ContainerInterface $container)
    {
        $this->translator = $this->container->get(TranslatorInterface::class);
        $this->telegramService = $this->container->get(TelegramService::class);
    }

    /**
     * @param ConstraintViolationListInterface $errors
     * @param string $attribute
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     */
    public function hasErrors(ConstraintViolationListInterface $errors): bool
    {
        return $errors->count() !== 0;
    }

    /**
     * @param string $attribute
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     */
    public function throwValidationErrorMessage(string $attribute, int|string ...$args): void
    {
        // TODO: add some service for deleting previous messages of user and bot
        $log = TemporaryLog::byChatId($_SESSION['chat_id'])->first();
        $this->telegramService->deleteMessages($_SESSION['chat_id'], [
            $log->data['message_id_of_bot_question'],
            $log->data['message_id_of_user_answer'],
        ]);

        $data = $this->telegramService->sendMessage(
            $this->translator->trans(
                sprintf('validation.errors.invalid.' . $attribute, $args),
                locale: $_SESSION['locale']
            ),
            $_SESSION['chat_id'],
            ForceReplyDTO::make(true),
        );

        // TODO: add some service for adding message_id bot's question to current chat id
        TemporaryLog::updateOrCreate([
            'chat_id' => $_SESSION['chat_id'],
        ], [
            'data' => ['message_id_of_bot_question' => $data['result']['message_id']],
        ]);
    }
}
