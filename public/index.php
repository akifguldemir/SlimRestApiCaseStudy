<?php
declare(strict_types=1);

use Slim\Factory\AppFactory;
use Slim\Factory\ServerRequestCreatorFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use DI\Container;


require __DIR__ . '/../vendor/autoload.php';

$container = new Container;
AppFactory ::setContainer($container);

$app = AppFactory::create();

// $serverRequest = ServerRequestCreatorFactory::create();

$app->get('/api/posts', function (Request $request, Response $response, $args) {

    $repository = $this->get(App\Repositories\PostRepository::class);

    $data = $repository->getAll();

    $body = json_encode($data);
    $response->getBody()->write($body);
    return $response->withHeader("Content-Type","application/json");
});

$app->run();


