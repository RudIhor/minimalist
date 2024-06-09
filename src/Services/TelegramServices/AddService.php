<?php

declare(strict_types=1);

namespace App\Services\TelegramServices;

use App\DataTransferObjects\ReplyMarkups\ForceReplyDTO;
use App\Models\TemporaryAction;
use Slim\App;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validation;

class AddService extends AbstractService
{
    /**
     * @param App $app
     * @param int $chatId
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __construct(App $app)
    {
        parent::__construct($app);

        $this->telegramService->sendMessage(
            $this->translator->trans('commands.add.step.1', locale: $_SESSION['language_code']),
            $_SESSION['chat_id'],
            ForceReplyDTO::make(true)
        );
    }

    /**
     * Validate a title.
     *
     * @param string $text
     * @param int $chatId
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     */
    public function firstStep(string $text, int $chatId): void
    {
        $title = trim($text);
        $validator = Validation::createValidator();
        $errors = $validator->validate($title, [
            new Length(['min' => 3, 'max' => 25]),
            new NotBlank(),
        ]);
        if ($errors->count() !== 0) {
            $this->telegramService->sendMessage(
                $this->translator->trans('validation.commands.add.title', locale: $_SESSION['language_code']),
                $chatId,
            );

            return;
        }
        // TODO: move to CreateTemporaryActionAction
        TemporaryAction::updateOrCreate(
            [
                'chat_id' => $chatId
            ],
            [
                'data' => ['class' => AddService::class, 'title' => $title],
            ]
        );
        $this->telegramService->sendMessage(
            'Please specify priority of the task from 1 to 3\(High to Low\)',
            $chatId,
            ForceReplyDTO::make(true),
        );
    }

    public function secondStep(string $text, int $chatId)
    {
        $temporaryAction = TemporaryAction::byChatId($chatId)->first();
    }
}
