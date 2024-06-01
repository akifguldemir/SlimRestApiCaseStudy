<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
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

$app->get('/api/posts', App\Controllers\PostIndex::class);

$error_middleware = $app->addErrorMiddleware(true, true, true);

$error_handler = $error_middleware->getDefaultErrorHandler();
$error_handler->forceContentType("application/json");

$app->add(new AddJsonResponseHeader);

$app->get('/api/posts/{id:[0-9]+}', function (Request $request, Response $response, $args) {

   $repository = $this->get(App\Repositories\PostRepository::class);
   $product = $repository->getById((int)$args['id']);

   if($product === false)
   {
    throw new HttpNotFoundException($request,
                message: "Post couldn't found");
   }

   $body = json_encode($product);

   $response->getBody()->write($body);
   return $response;

});

$app->run();


