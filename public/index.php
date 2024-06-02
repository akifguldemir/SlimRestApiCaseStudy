<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use App\Controllers\PostController;
use App\Controllers\UserController;
use Tuupola\Middleware\CorsMiddleware;
use App\Middleware\AddJsonResponseHeader;
use Slim\Exception\HttpNotFoundException;
use Slim\Factory\ServerRequestCreatorFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

define("APP_ROOT",dirname(__DIR__));

require APP_ROOT . '/vendor/autoload.php';

$builder = new ContainerBuilder;
$container = $builder->addDefinitions(APP_ROOT . '/config/definitions.php')->build();
AppFactory ::setContainer($container);

$app = AppFactory::create();

$app->add(new CorsMiddleware([
    "origin" => ["*"],
    "methods" => ["GET", "POST", "PUT", "DELETE", "OPTIONS"],
    "headers.allow" => ["Content-Type", "Authorization"],
    "headers.expose" => [],
    "credentials" => true,
    "cache" => 0,
]));

// $serverRequest = ServerRequestCreatorFactory::create();

$app->get('/api/posts', PostController::class. ':showAll');

$error_middleware = $app->addErrorMiddleware(true, true, true);

$error_handler = $error_middleware->getDefaultErrorHandler();
$error_handler->forceContentType("application/json");

$app->add(new AddJsonResponseHeader);

$app->delete("/api/posts/{id:[0-9]+}", App\Controllers\PostController::class. ':delete');

$app->post("/api/login", UserController::class. ':login');

$app->run();


