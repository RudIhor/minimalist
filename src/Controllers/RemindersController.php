<?php

declare(strict_types=1);

namespace App\Controllers;

use _PHPStan_18cddd6e5\Nette\Neon\Exception;
use App\Actions\Reminders\SendTodoReminderAction;
use App\Enums\DayTime;
use App\Services\HashService;
use App\Services\ViewServices\ViewTasksService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class RemindersController extends Controller
{
    private SendTodoReminderAction $todoReminderAction;

    /**
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->todoReminderAction = new SendTodoReminderAction(
            new ViewTasksService($this->container),
            $this->container->get(TranslatorInterface::class),
            $this->container->get(HashService::class)
        );
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
    public function sendMorningReminders(
        ServerRequestInterface $request,
        ResponseInterface $response,
    ): ResponseInterface {
        $this->todoReminderAction->handle(DayTime::Morning);

        return $response;
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
    public function sendAfternoonReminders(
        ServerRequestInterface $request,
        ResponseInterface $response,
    ): ResponseInterface {
        $this->todoReminderAction->handle(DayTime::Afternoon);

        return $response;
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
    public function sendEveningReminders(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        $this->todoReminderAction->handle(DayTime::Evening);

        return $response;
    }
}
