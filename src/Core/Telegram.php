<?php

namespace App\Core;

use App\Enums\ParseMode;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

class Telegram
{
    private Client $client;
    private LoggerInterface $log;

    public function __construct()
    {
        $uri = 'https://api.telegram.org/bot' . $_ENV['TELEGRAM_BOT_TOKEN'] . '/';
        $this->client = new Client([
            'base_uri' => $uri,
        ]);
        $this->log = new Logger('telegram');
        $this->log->pushHandler(new StreamHandler(dirname(__DIR__, 2) . '/logs/telegram.log'));
    }

    public function getMe(): ?array
    {
        try {
            return GuzzleHelper::responseToArray($this->client->get('getMe'));
        } catch (RequestException $e) {
            $this->log->error($e->getMessage());

            return null;
        }
    }

    public function sendMessage(string $text): ?array
    {
        try {
            return GuzzleHelper::responseToArray($this->client->post('sendMessage', [
                'json' => [
                    'text' => $text,
                    'parse_mode' => ParseMode::MarkdownV2->value,
                ],
            ]));
        } catch (RequestException $e) {
            $this->log->error($e->getMessage());

            return null;
        }
    }

    public function setWebhook(string $url): ?array
    {
        try {
            return GuzzleHelper::responseToArray($this->client->post('setWebhook', [
                'json' => ['url' => $url],
            ]));
        } catch (RequestException $e) {
            $this->log->error($e->getMessage());

            return null;
        }
    }
}
