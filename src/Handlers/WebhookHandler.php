<?php

declare(strict_types=1);

namespace App\Handlers;

use App\Actions\Log\CreateLogAction;
use App\Core\ButtonHelper;
use App\Core\TelegramService;
use App\Entities\Update;
use App\Enums\ActionStrategy;
use App\Enums\AvailableCommand;
use App\Exceptions\TelegramException;
use App\Models\TemporaryLog;
use App\Models\User;
use App\Services\ValidationMapper;
use App\TelegramCommands\AbstractCommand;
use App\TelegramCommands\NotFoundCommand;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use Slim\App;
use Symfony\Contracts\Translation\TranslatorInterface;

readonly class WebhookHandler
{
    public Update $update;

    protected TelegramService $telegramService;

    private TranslatorInterface $translator;

    /**
     * @param App $app
     * @param array $data
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __construct(public App $app, array $data)
    {
        $this->telegramService = $app->getContainer()->get(TelegramService::class);
        $this->translator = $app->getContainer()->get(TranslatorInterface::class);
        $message = $data['message'];
        try {
            $this->update = Update::from($data);
        } catch (TelegramException $e) {
            $this->telegramService->sendMessage(
                $this->translator->trans($e->getMessage(), locale: $message['from']['language_code']),
                $message['chat']['id']
            );
        }
        if (!empty($this->update->message) && str_starts_with($this->update->message->text, '/')) {
            if (!empty(User::byChatId($this->update->message->chat->id)->first())) {
                (new CreateLogAction())->execute(
                    ['data' => $this->update->message->text, 'chat_id' => $this->update->message->chat->id]
                );
            }
        }
        $_SESSION['chat_id'] = $this->update->message?->chat->id ?? $this->update->callbackQuery?->message->chat->id;
        $_SESSION['locale'] = $this->update->message?->from->languageCode ?? User::byChatId(
            $_SESSION['chat_id']
        )->first()->language_code;
        $_SESSION['message_id'] = $this->update->callbackQuery?->message?->id;
    }

    /**
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function handle(): bool
    {
        $text = $this->update->message?->text;
        return match (true) {
            !empty($this->update->callbackQuery) => $this->handleCallback(
                $this->update->callbackQuery->message->id
            ),
            !empty($this->update->message->replyToMessage) => $this->handleReply($text),
            default => $this->handleDefaultCommands($text),
        };
    }

    /**
     * @param int $messageId
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    private function handleCallback(int $messageId): bool
    {
        if (count($parts = explode('/', $this->update->callbackQuery->data)) === 3) {
            [$timestamp, $action, $id] = $parts;
        } else {
            [$timestamp, $action] = $parts;
        }
        $date = Carbon::createFromTimestampUTC($timestamp);
        if ($action === 'back') {
            $temporaryLog = TemporaryLog::byChatId($this->update->callbackQuery?->message->chat->id)->first();
            $this->telegramService->editSentMessageText(
                $temporaryLog->data['previous_message_text'],
                $this->update->callbackQuery?->message->chat->id,
                $messageId,
                ButtonHelper::getDefaultButtons($date->unix()),
            );

            return true;
        }
        $class = ActionStrategy::getServiceClass($action);
        $taskService = new $class($this->app->getContainer(), $messageId);
        if (!empty($id)) {
            $taskService->run((int)$id, $this->update->callbackQuery?->message->chat->id);
        } else {
            $taskService->run($date, $this->update->callbackQuery?->message->chat->id);
        }

        return true;
    }

    /**
     * @param string $answer
     * @return bool
     */
    private function handleReply(string $answer): bool
    {
        TemporaryLog::updateOrCreate([
            'chat_id' => $this->update->message->chat->id,
        ], [
            'data' => ['message_id_of_user_answer' => $this->update->message->id],
        ]);
        [$validatorClass, $method] = (new ValidationMapper())->run($this->update->message->replyToMessage->text);
        if (!empty($validatorClass) && !empty($method)) {
            (new $validatorClass($this->app->getContainer()))->{$method}($answer);

            return true;
        }

        return false;
    }

    /**
     * @param string $text
     * @return bool
     */
    private function handleDefaultCommands(string $text): bool
    {
        if (in_array($text, array_keys(AvailableCommand::all()))) {
            $class = AvailableCommand::all()[$text];
        } else {
            $class = NotFoundCommand::class;
        }
        /** @var AbstractCommand $telegramCommand */
        $telegramCommand = new $class($this->app->getContainer());
        $telegramCommand->execute($this->update);

        return true;
    }
}
