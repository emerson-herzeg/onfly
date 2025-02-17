<?php

namespace Tests\Unit;

use App\Services\AuthService;
use App\Interfaces\UserRepositoryInterface;
use Tymon\JWTAuth\Facades\JWTAuth;
use PHPUnit\Framework\TestCase;
use Mockery;

class AuthServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function test_user_authentication_success()
    {
        // Mock do UserRepositoryInterface
        $userRepository = Mockery::mock(UserRepositoryInterface::class);
        $user = (object) ['email' => 'test@example.com', 'password' => password_hash('password123', PASSWORD_BCRYPT)];

        // Configurar o comportamento esperado
        $userRepository->shouldReceive('findByEmail')
            ->with('test@example.com')
            ->andReturn($user);

        // Simular o JWTAuth para retornar um token válido
        JWTAuth::shouldReceive('fromUser')
            ->with($user)
            ->andReturn('fake_jwt_token');

        // Instanciar o serviço com o mock
        $authService = new AuthService($userRepository);
        $token = $authService->attemptLogin(['email' => 'test@example.com', 'password' => 'password123']);

        $this->assertEquals('fake_jwt_token', $token);
    }

    public function test_user_authentication_failure_invalid_password()
    {
        $userRepository = Mockery::mock(UserRepositoryInterface::class);
        $user = (object) ['email' => 'test@example.com', 'password' => password_hash('correctPassword', PASSWORD_BCRYPT)];

        $userRepository->shouldReceive('findByEmail')
            ->with('test@example.com')
            ->andReturn($user);

        JWTAuth::shouldReceive('fromUser')->never();

        $authService = new AuthService($userRepository);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Credenciais inválidas');

        $authService->attemptLogin(['email' => 'test@example.com', 'password' => 'wrongPassword']);
    }
}
