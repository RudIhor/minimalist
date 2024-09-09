<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Factories\ViewTasksMessage\EveningViewMessage;
use App\Factories\ViewTasksMessage\MorningViewMessage;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\HashService;
use App\Services\ViewServices\ViewTasksService;
use Carbon\Carbon;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class RemindersController extends Controller
{
    private ViewTasksService $viewTasksService;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->viewTasksService = new ViewTasksService($this->container);
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function sendRemindersInTheMorning(
        ServerRequestInterface $request,
        ResponseInterface $response,
    ): ResponseInterface {
        $chatIdsObjects = UserRepository::getChatIdThatHasTasksForDate(Carbon::today());
        foreach ($chatIdsObjects as $chatIdObj) {
            $user = User::byChatId($chatIdObj->chat_id)->first();
            $tasks = $user->tasks()->byDate(Carbon::today())->get();
            $date = Carbon::today()->locale($user->language_code);
            $viewMessage = new MorningViewMessage(
                $date,
                $this->container->get(TranslatorInterface::class),
                $this->container->get(HashService::class),
                $user->language_code
            );

            $this->viewTasksService->sendNewMessage($user->chat_id, $viewMessage->getText($tasks), $date);
        }

        return $response;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function sendRemindersInTheEvening(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        $chatIdsObjects = UserRepository::getChatIdThatHasTasksForDate(Carbon::today());
        foreach ($chatIdsObjects as $chatIdObj) {
            $user = User::byChatId($chatIdObj->chat_id)->first();
            $tasks = $user->tasks()->byDate(Carbon::today())->get();
            $date = Carbon::today()->locale($user->language_code);
            $viewMessage = new EveningViewMessage(
                $date,
                $this->container->get(TranslatorInterface::class),
                $this->container->get(HashService::class),
                $user->language_code
            );

            $this->viewTasksService->sendNewMessage($user->chat_id, $viewMessage->getText($tasks), $date);
        }

        return $response;
    }
}
