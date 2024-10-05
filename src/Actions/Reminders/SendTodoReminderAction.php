<?php

declare(strict_types=1);

namespace App\Actions\Reminders;

use App\Enums\DayTime;
use App\Factories\ViewTasksMessage\AbstractViewMessageFactory;
use App\Factories\ViewTasksMessage\EveningViewMessage;
use App\Factories\ViewTasksMessage\MorningViewMessage;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\HashService;
use App\Services\ViewServices\ViewTasksService;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Contracts\Translation\TranslatorInterface;

readonly class SendTodoReminderAction
{
    public function __construct(
        private ViewTasksService $viewTasksService,
        private TranslatorInterface $translator,
        private HashService $hashService,
    ) {
    }

    /**
     * Send the reminder based on time of the day for today.
     *
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function handle(DayTime $dayTime): void
    {
        $usersWithTasks = UserRepository::getChatIdThatHasTasksForDate(Carbon::today());
        foreach ($usersWithTasks as $userWithTask) {
            $user = User::byChatId($userWithTask->chat_id)->first();
            $tasks = $user->tasks()->byDate(Carbon::today())->get();
            $date = Carbon::today()->locale($user->language_code);
            $viewMessage = $this->getViewMessage($dayTime, $date, $user);

            $this->viewTasksService->sendNewMessage($user->chat_id, $viewMessage->getText($tasks), $date);
        }
    }

    /**
     * Get view message for the given time of the day.
     *
     * @param DayTime $dayTime
     * @param Carbon $date
     * @param User $user
     * @return AbstractViewMessageFactory
     */
    public function getViewMessage(DayTime $dayTime, Carbon $date, User $user): AbstractViewMessageFactory
    {
        return match ($dayTime) {
            DayTime::Morning, DayTime::Afternoon => new MorningViewMessage(
                $date,
                $this->translator,
                $this->hashService,
                $user->language_code
            ),
            DayTime::Evening => new EveningViewMessage(
                $date,
                $this->translator,
                $this->hashService,
                $user->language_code
            ),
        };
    }
}
