<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\UserRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserController
{
    public function __construct(private UserRepository $repository)
    {
        $test = 1;
    }

    
    public function login(Request $request, Response $response): Response
    {
        $queryParams = $request->getParsedBody();
        $email = $queryParams['email'] ?? null;
        $password = $queryParams['password'] ?? null;
        if ($email && $password) {
            $user = $this->repository->findByEmail($email);
            if ($user && password_verify($password, $user['password'])) {
                if ($user['role'] === 'role_admin') {
                    $responseData = json_encode([
                        'status' => 'success',
                        'message' => 'Login başarılı. Yönlendiriliyor..',
                        'code' => 200
                    ]);
                    $response->getBody()->write($responseData); 
                    return $response->withHeader('Content-Type', 'application/json')
                                    ->withStatus(200);
                } else {
                    $responseData = json_encode([
                        'status' => 'error',
                        'message' => 'Kullanıcı bulunamadı veya hatalı giriş bilgileri',
                        'code' => 400
                    ]);
    
                    $response->getBody()->write($responseData); 
                    return $response->withHeader('Content-Type', 'application/json')
                                    ->withStatus(400);
                }
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