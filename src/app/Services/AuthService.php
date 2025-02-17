<?php

namespace App\Services;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Interfaces\UserRepositoryInterface;

class AuthService
{
    private UserRepositoryInterface $userRepositoryInterface;

    // Injeção de dependências no construtor
    public function __construct(UserRepositoryInterface $userRepositoryInterface)
    {
        $this->userRepositoryInterface = $userRepositoryInterface;
    }

    public function attemptLogin(array $credentials): string
    {
        try {
            $user = $this->userRepositoryInterface->findByEmail($credentials['email']);

            if (!$user || !password_verify($credentials['password'], $user->password)) {
                throw new \Exception('Credenciais inválidas');
            }

            if (!$token = JWTAuth::fromUser($user)) {
                throw new JWTException('Could not create token');
            }

            return $token;

        } catch (JWTException $e) {
            throw new \Exception('Could not create token');
        }
    }
}
