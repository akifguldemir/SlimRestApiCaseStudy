<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\UserRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class User
{
    public function __construct(private UserRepository $repository)
    {
    }

    
    public function login(Request $request, Response $response, array $args): Response
    {
        $queryParams = $request->getQueryParams();
        $email = $queryParams['email'] ?? null;
        $password = $queryParams['password'] ?? null;

        if ($email && $password) {
            $user = $this->repository->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                $responseData = json_encode([
                    'status' => 'success',
                    'user' => $user,
                    'code' => 200
                ]);

                $response->getBody()->write($responseData); 
                return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
            }
        }

        $responseData = json_encode([
            'status' => 'error',
            'message' => 'Kullanıcı bulunamadı veya hatalı giriş bilgileri',
            'code' => 400
        ]);

        $response->getBody()->write($responseData); 
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);    
    }

   
}