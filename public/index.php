<?php

declare(strict_types=1);

use App\Application\Handlers\HttpErrorHandler;
use App\Application\Handlers\ShutdownHandler;
use App\Application\ResponseEmitter\ResponseEmitter;
use App\Application\Settings\SettingsInterface;
use App\Core\TelegramService;
use DI\ContainerBuilder;
use Dotenv\Dotenv;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Slim\Factory\AppFactory;
use Slim\Factory\ServerRequestCreatorFactory;

use function Sentry\init;

require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/constants.php';

session_start();

$dotenv = Dotenv::createImmutable(BASE_PATH);
$dotenv->load();

init([
    'dsn' => $_ENV['SENTRY_DSN'],
    'traces_sample_rate' => 1.0,
    'profiles_sample_rate' => 1.0,
]);

// Instantiate PHP-DI ContainerBuilder
$containerBuilder = new ContainerBuilder();

if (!$_ENV['APP_DEBUG']) { // Should be set to true in production
    $containerBuilder->enableCompilation(__DIR__ . '/../var/cache');
}

// Set up settings
$settings = require __DIR__ . '/../app/settings.php';
$settings($containerBuilder);

// Set up dependencies
$dependencies = require __DIR__ . '/../app/dependencies.php';
$dependencies($containerBuilder);

// Set up repositories
$repositories = require __DIR__ . '/../app/repositories.php';
$repositories($containerBuilder);

// Build PHP-DI Container instance
$container = $containerBuilder->build();

// Instantiate the app
AppFactory::setContainer($container);
$app = AppFactory::create();
$callableResolver = $app->getCallableResolver();

// Register middleware
$middleware = require __DIR__ . '/../app/middleware.php';
$middleware($app);

// Register routes
$routes = require __DIR__ . '/../app/routes.php';
$routes($app);

/** @var SettingsInterface $settings */
$settings = $container->get(SettingsInterface::class);

$eloquent = require __DIR__ . '/../app/eloquent.php';
$eloquent($app, $settings);

$displayErrorDetails = $settings->get('displayErrorDetails');
$logError = $settings->get('logError');
$logErrorDetails = $settings->get('logErrorDetails');

// Create Request object from globals
$serverRequestCreator = ServerRequestCreatorFactory::create();
$request = $serverRequestCreator->createServerRequestFromGlobals();

// Create Error Handler
$responseFactory = $app->getResponseFactory();
$errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);

// Create Shutdown Handler
$shutdownHandler = new ShutdownHandler($request, $errorHandler, $displayErrorDetails);
register_shutdown_function($shutdownHandler);

// Add Routing Middleware
$app->addRoutingMiddleware();

// Add Body Parsing Middleware
$app->addBodyParsingMiddleware();

// Add Error Middleware
$errorMiddleware = $app->addErrorMiddleware($displayErrorDetails, $logError, $logErrorDetails);
$customErrorHandler = function (ServerRequestInterface $request, Throwable $exception) use ($app) {
    $logger = $app->getContainer()->get(LoggerInterface::class);
    $logger?->error($exception->getMessage() . ' ' . $exception->getFile() . ' ' . $exception->getLine());

    if (!empty($_SESSION['chat_id'])) {
        /** @var TelegramService $telegramService */
        $telegramService = $app->getContainer()->get(TelegramService::class);
        $telegramService->sendMessage('Houston, we have a problem', $_SESSION['chat_id']);
    }

    $response = $app->getResponseFactory()->createResponse();
    $response->getBody()->write(json_encode(['error' => $exception->getMessage()], JSON_UNESCAPED_UNICODE));

    return $response;
};
$errorMiddleware->setDefaultErrorHandler($customErrorHandler);

// Run App & Emit Response
$response = $app->handle($request);
$responseEmitter = new ResponseEmitter();
$responseEmitter->emit($response);
