<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use App\Controllers\PostController;
use App\Controllers\UserController;
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

// $serverRequest = ServerRequestCreatorFactory::create();

$app->get('/api/posts', PostController::class. ':showAll');

$error_middleware = $app->addErrorMiddleware(true, true, true);

$error_handler = $error_middleware->getDefaultErrorHandler();
$error_handler->forceContentType("application/json");

$app->add(new AddJsonResponseHeader);

$app->delete("/api/posts/{id:[0-9]+}", App\Controllers\PostController::class. ':delete');

$app->get("/api/login", UserController::class. ':login');

$app->run();


