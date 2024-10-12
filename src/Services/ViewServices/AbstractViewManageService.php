<?php

declare(strict_types=1);

namespace App\Services\ViewServices;

use App\Core\ButtonHelper;
use App\DataTransferObjects\ReplyMarkups\InlineKeyboardMarkupDTO;
use App\Entities\CallbackData;
use App\Enums\TaskAction;
use App\Factories\ViewTasksMessage\NoTaskFoundViewMessage;
use App\Services\AbstractService;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Psr\Container\ContainerInterface;
use Random\RandomException;

abstract class AbstractViewManageService extends AbstractService
{
    protected ViewTasksService $viewTasksService;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->viewTasksService = new ViewTasksService($container);
    }

    /**
     * @param Carbon $date
     * @param int $chatId
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     * @throws RandomException
     */
    public function run(Carbon $date, int $chatId): void
    {
        parent::run($date, $chatId);

        $tasks = $this->getUserTasks($date, $chatId);
        $inlineKeyboard = $this->getInlineKeyboardForTasks($tasks, $date);
        $inlineKeyboard[] = ButtonHelper::getBackButton($date->unix());

        $viewMessage = new NoTaskFoundViewMessage($date, $this->translator, $this->hashService);

        if (count($inlineKeyboard) === 1) {
            $resultText = $this->translator->trans('commands.no-tasks-to.' . $this->getAction()->value);
            // ensure we have unique string even for the same state (e.g. user clicks twice and the same message)
            $resultText .= ' ' . $this->getRandomString();
            $this->viewTasksService->editSentMessage(
                $_SESSION['message_id'],
                $chatId,
                $viewMessage->getText(collect()),
                $date,
                $resultText
            );
            return;
        }
        $this->telegramService->editSentMessageText(
            $this->translator->trans('commands.specify-task-to.' . $this->getAction()->value, locale: $_SESSION['locale']),
            $chatId,
            $_SESSION['message_id'],
            InlineKeyboardMarkupDTO::make($inlineKeyboard)
        );
    }

    abstract public function getUserTasks(Carbon $date, int $chatId): Collection;

    abstract public function getAction(): TaskAction;

    private function getInlineKeyboardForTasks(Collection $tasks, Carbon $date): array
    {
        $inlineKeyboard = [];
        $temp = [];
        $count = count($tasks);
        for ($i = 0; $i < $count; $i++) {
            if (!empty($tasks[$i])) {
                $callbackData = CallbackData::from(
                    $date->unix(),
                    $this->getAction()->value,
                    $tasks[$i]->id
                );
                $temp[] = ButtonHelper::createCallbackButton(
                    $this->hashService->decrypt($tasks[$i]->title),
                    $callbackData
                );
                if (count($temp) === 3 || $i === $count - 1) {
                    $inlineKeyboard[] = $temp;
                    $temp = [];
                }
            }
        }

        return $inlineKeyboard;
    }


    /**
     * Returns random spoiler string, which allows to avoid the same message error in Bot API.
     *
     * @throws RandomException
     */
    private function getRandomString(): string
    {
        return '||' . random_int(1, 1000) . '||';
    }
}
