<?php

declare(strict_types=1);

namespace App\Commands;

use App\Core\TelegramService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('telegram:set-webhook', 'Set webhook for Telegram bot')]
class SetWebhookCommand extends AbstractCommand
{
    private TelegramService $telegramService;

    public function __construct()
    {
        parent::__construct();
        $this->telegramService = new TelegramService($_ENV['TELEGRAM_BOT_TOKEN']);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $url = $_ENV['APP_URL']  . '/' . 'webhook';
        $this->telegramService->setWebhook($url);
        $output->writeln('Telegram webhook was successfully set. Url: ' . $url);

        return Command::SUCCESS;
    }
}
