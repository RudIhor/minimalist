<?php

declare(strict_types=1);

namespace App\Commands;

use App\Core\TelegramService;
use App\Enums\AvailableCommand;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('telegram:set-commands', 'Set commands for Telegram bot')]
class SetTelegramCommandsCommand extends AbstractCommand
{
    private TelegramService $telegramService;

    public function __construct()
    {
        parent::__construct();
        $this->telegramService = new TelegramService($_ENV['TELEGRAM_BOT_TOKEN']);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->telegramService->setMyCommands(AvailableCommand::registeredCommands());
        $output->writeln('Commands were successfully set!');

        return Command::SUCCESS;
    }
}
