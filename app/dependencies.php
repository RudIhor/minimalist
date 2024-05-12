<?php

declare(strict_types=1);

use App\Application\Settings\SettingsInterface;
use App\Core\Telegram;
use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Translation\Loader\PhpFileLoader;
use Symfony\Component\Translation\Translator;
use Symfony\Contracts\Translation\TranslatorInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $loggerSettings = $settings->get('logger');
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },
        Telegram::class => function () {
            return new Telegram();
        },
        TranslatorInterface::class => function () {
            $translator = new Translator($_ENV['APP_LOCALE']);
            $translator->addLoader('array', new PhpFileLoader());
            $translator->addResource('array', dirname(__DIR__) . '/translations/en/telegram.php', 'en');
            $translator->addResource('array', dirname(__DIR__) . '/translations/uk/telegram.php', 'uk');

            return $translator;
        }
    ]);
};
