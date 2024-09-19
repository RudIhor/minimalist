<?php

declare(strict_types=1);

namespace App\Core;

use App\DataTransferObjects\ReplyMarkups\AbstractReplyMarkup;
use App\Enums\ParseMode;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;

class TelegramService
{
    private Client $client;

    public function __construct(string $botToken)
    {
        $uri = 'https://api.telegram.org/bot' . $botToken . '/';
        $this->client = new Client([
            'base_uri' => $uri,
        ]);
    }

    /**
     * A simple method for testing your bot's authentication token.
     * https://core.telegram.org/bots/api#getme
     *
     * @return array|null
     * @throws GuzzleException
     * @throws JsonException
     */
    public function getMe(): ?array
    {
        return GuzzleHelper::responseToArray($this->client->get('getMe'));
    }

    /**
     * Send the message.
     * https://core.telegram.org/bots/api#sendmessage
     *
     * @param string $text
     * @param int $chatId
     * @param AbstractReplyMarkup|null $replyMarkup
     * @return array|null
     * @throws GuzzleException
     * @throws JsonException
     */
    public function sendMessage(string $text, int $chatId, ?AbstractReplyMarkup $replyMarkup = null): ?array
    {
        $data = [
            'text' => $this->escapeTelegramCharacters($text),
            'chat_id' => $chatId,
            'parse_mode' => ParseMode::MarkdownV2->value,
        ];
        if (!empty($replyMarkup)) {
            $data['reply_markup'] = $replyMarkup->toArray();
        }

        return GuzzleHelper::responseToArray($this->client->post('sendMessage', ['json' => $data]));
    }

    /**
     *  Edit the text of the message.
     *  https://core.telegram.org/bots/api#editmessagetext
     *
     * @param string $text
     * @param int $chatId
     * @param int $messageId
     * @param AbstractReplyMarkup|null $replyMarkup
     * @return array|null
     * @throws GuzzleException
     * @throws JsonException
     */
    public function editSentMessageText(
        string $text,
        int $chatId,
        int $messageId,
        ?AbstractReplyMarkup $replyMarkup = null
    ): ?array {
        // $_SESSION[chat_id] probably needs to be a class's variable
        $data = [
            'text' => $this->escapeTelegramCharacters($text),
            'chat_id' => $chatId,
            'message_id' => $messageId,
            'parse_mode' => ParseMode::MarkdownV2->value,
        ];
        if (!empty($replyMarkup)) {
            $data['reply_markup'] = $replyMarkup->toArray();
        }

        return GuzzleHelper::responseToArray($this->client->post('editMessageText', ['json' => $data]));
    }

    /**
     * Delete messages by its IDs
     * https://core.telegram.org/bots/api#deletemessages
     *
     * @param int $chatId
     * @param array $messageIds
     * @return bool
     * @throws GuzzleException
     * @throws JsonException
     */
    public function deleteMessages(int $chatId, array $messageIds): bool
    {
        $data = [
            'chat_id' => $chatId,
            'message_ids' => $messageIds,
        ];

        return GuzzleHelper::responseToArray($this->client->post('deleteMessages', ['json' => $data]))['result'];
    }

    /**
     * Edit the caption of the message
     * https://core.telegram.org/bots/api#editmessagecaption
     *
     * @param string $text
     * @param int $chatId
     * @param int $messageId
     * @return array
     * @throws GuzzleException
     * @throws JsonException
     */
    public function editMessageCaption(string $text, int $chatId, int $messageId): array
    {
        return GuzzleHelper::responseToArray($this->client->post('editMessageCaption', [
            'json' => [
                'caption' => $text,
                'chat_id' => $chatId,
                'message_id' => $messageId,
            ]
        ]));
    }

    /**
     * @param string $text
     * @param int $chatId
     * @return mixed
     * @throws GuzzleException
     * @throws JsonException
     */
    public function loading(string $text, int $chatId): int
    {
        return $this->sendMessage($text, $chatId)['result']['message_id'];
    }

    /**
     * Set the webhook.
     * https://core.telegram.org/bots/api#setwebhook
     *
     * @param string $url
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws JsonException
     */
    public function setWebhook(string $url): ?array
    {
        return GuzzleHelper::responseToArray($this->client->post('setWebhook', [
            'json' => [
                'url' => $url,
            ],
        ]));
    }

    /**
     * Register commands in Telegram Bot.
     * https://core.telegram.org/bots/api#setmycommands
     *
     * @param array $commands
     * @return array|null
     * @throws GuzzleException
     * @throws JsonException
     */
    public function setMyCommands(array $commands): ?array
    {
        return GuzzleHelper::responseToArray($this->client->post('setMyCommands', [
            'json' => [
                'commands' => $commands,
            ],
        ]));
    }

    /**
     * Escape non-valid characters for Telegram API.
     *
     * @param string $text
     * @return array|string
     */
    private function escapeTelegramCharacters(string $text): array|string
    {
        foreach (['.', '!', ':', '-', '(', ')', '#', '`'] as $character) {
            $text = str_replace($character, sprintf("\%s", $character), $text);
        }

        return $text;
    }
}
