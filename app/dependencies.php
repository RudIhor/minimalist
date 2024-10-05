<?php

declare(strict_types=1);

use App\Application\Settings\SettingsInterface;
use App\Core\TelegramService;
use App\Services\HashService;
use DI\ContainerBuilder;
use Dotenv\Dotenv;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Translation\Loader\PhpFileLoader;
use Symfony\Component\Translation\Translator;
use Symfony\Contracts\Translation\TranslatorInterface;

return function (ContainerBuilder $containerBuilder) {
    $dotenv = Dotenv::createImmutable(BASE_PATH);
    $dotenv->load();
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
        TelegramService::class => function () {
            return new TelegramService($_ENV['TELEGRAM_BOT_TOKEN']);
        },
        HashService::class => function () {
            return new HashService();
        },
        TranslatorInterface::class => function () {
            $translator = new Translator($_SESSION['locale'] ?? 'en');
            $translator->addLoader('array', new PhpFileLoader());
            $translator->addResource('array', dirname(__DIR__) . '/resources/languages/en/telegram.php', 'en');
            $translator->addResource('array', dirname(__DIR__) . '/resources/languages/en/questions.php', 'en');

            $translator->addResource('array', dirname(__DIR__) . '/resources/languages/uk/telegram.php', 'uk');
            $translator->addResource('array', dirname(__DIR__) . '/resources/languages/uk/questions.php', 'uk');

            $translator->addResource('array', dirname(__DIR__) . '/resources/languages/ru/telegram.php', 'ru');
            $translator->addResource('array', dirname(__DIR__) . '/resources/languages/ru/questions.php', 'ru');

            $translator->addResource('array', dirname(__DIR__) . '/resources/languages/es/telegram.php', 'es');
            $translator->addResource('array', dirname(__DIR__) . '/resources/languages/es/questions.php', 'es');

            $translator->addResource('array', dirname(__DIR__) . '/resources/languages/de/telegram.php', 'de');
            $translator->addResource('array', dirname(__DIR__) . '/resources/languages/de/questions.php', 'de');

            $translator->addResource('array', dirname(__DIR__) . '/resources/languages/fr/telegram.php', 'fr');
            $translator->addResource('array', dirname(__DIR__) . '/resources/languages/fr/questions.php', 'fr');

            $translator->addResource('array', dirname(__DIR__) . '/resources/languages/kk/telegram.php', 'kk');
            $translator->addResource('array', dirname(__DIR__) . '/resources/languages/kk/questions.php', 'kk');

            $translator->addResource('array', dirname(__DIR__) . '/resources/languages/pl/telegram.php', 'pl');
            $translator->addResource('array', dirname(__DIR__) . '/resources/languages/pl/questions.php', 'pl');

            return $translator;
        }
    ]);
};
