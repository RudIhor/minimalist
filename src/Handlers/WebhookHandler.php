<?php

declare(strict_types=1);

namespace App\Handlers;

use App\Entities\Update;
use App\Enums\AvailableCommand;
use App\Services\TelegramServices\AbstractService;
use App\TelegramCommands\AbstractCommand;
use App\TelegramCommands\NotFoundCommand;
use Slim\App;

readonly class WebhookHandler
{
    public Update $update;

    public function __construct(public App $app, array $data)
    {
        $this->update = Update::from($data);
        $_SESSION['chat_id'] = $this->update->message->chat->id;
        $_SESSION['language_code'] = $this->update->message->from->languageCode;
    }

    public function handle(): void
    {
        $text = $this->update->message->text;
        if (!empty($this->update->message->replyToMessage)) {
            $steps = require(BASE_PATH . '/resources/steps.php');
            $questionText = $this->update->message->replyToMessage->text;
            foreach ($steps as $service => $questions) {
                /** @var AbstractService $service */
                if (!empty($step = $questions[$questionText])) {
                    (new $service($this->app))->handle($step, $text, $this->update->message->chat->id);

                    return;
                }
            }
        }
        if (in_array($text, array_keys(AvailableCommand::all()))) {
            $class = AvailableCommand::all()[$text];
        } else {
            $class = NotFoundCommand::class;
        }
        /** @var AbstractCommand $telegramCommand */
        $telegramCommand = new $class($this->app);
        $telegramCommand->execute($this->update);
    }
}
