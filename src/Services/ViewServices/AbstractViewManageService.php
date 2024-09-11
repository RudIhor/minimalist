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
     */
    public function run(Carbon $date, int $chatId): void
    {
        parent::run($date, $chatId);

        $tasks = $this->getUserTasks($date, $chatId);
        $inlineKeyboard = $this->getInlineKeyboardForTasks($tasks, $date);

        if (count($inlineKeyboard) === 1) {
            $temp = $inlineKeyboard[0];
            $inlineKeyboard[0] = [ButtonHelper::getBackButton($date->unix())];
        } else {
            $temp = $inlineKeyboard[1];
            $inlineKeyboard[1] = [ButtonHelper::getBackButton($date->unix())];
        }
        $inlineKeyboard[] = $temp;

        $viewMessage = new NoTaskFoundViewMessage($date, $this->translator, $this->hashService);

        if (count($inlineKeyboard) === 1) {
            $this->viewTasksService->editSentMessage(
                $_SESSION['message_id'],
                $chatId,
                $viewMessage->getText(collect()),
                $date,
                $this->translator->trans('commands.no-tasks-to.' . $this->getAction()->value)
            );
            return;
        }
        $this->telegramService->editSentMessageText(
            $this->translator->trans('commands.specify-task-to.' . $this->getAction()->value,),
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
}
