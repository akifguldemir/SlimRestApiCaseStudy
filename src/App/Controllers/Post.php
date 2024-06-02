<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\PostRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Post
{
    public function __construct(private PostRepository $repository)
    {
    }

    public function showAll(Request $request, Response $response): Response
    {
        $data = $this->repository->getAll();
    
        $body = json_encode($data);
    
        $response->getBody()->write($body);
    
        return $response;
    }

    public function delete(Request $request, Response $response, array $args): Response
    {
        $rows = $this->repository->delete((int)$args['id']);

        if ($rows > 0) {
            $body = json_encode([
                'message' => 'Post deleted',
                'affectedRows' => $rows,
                'code' => 200,
            ]);

            $response->getBody()->write($body); 
            return $response->withHeader('Content-Type', 'application/json')
                            ->withStatus(200);
        } else {
            $body = json_encode([
                'message' => 'Post not found',
                'affectedRows' => $rows,
                'code' => 404,
            ]);

            $response->getBody()->write($body); 
            return $response->withHeader('Content-Type', 'application/json')
                            ->withStatus(404);
        }
    }

   
}