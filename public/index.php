<?php
declare(strict_types=1);

use Slim\Factory\AppFactory;
use Slim\Factory\ServerRequestCreatorFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use DI\ContainerBuilder;

define("APP_ROOT",dirname(__DIR__));

require APP_ROOT . '/vendor/autoload.php';

$builder = new ContainerBuilder;
$container = $builder->addDefinitions(APP_ROOT . '/config/definitions.php')->build();
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

$app->get('/api/posts/{id:[0-9]+}', function (Request $request, Response $response, $args) {

   $repository = $this->get(App\Repositories\PostRepository::class);
   $product = $repository->getById((int)$args['id']);

   $body = json_encode($product);

   $response->getBody()->write($body);
   return $response->withHeader("Content-Type","application/json");

});

$app->run();


