<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use App\Services\ApiResponseService;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use App\Http\Middleware\JwtMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'jwtAuth' => JwtMiddleware::class
        ]);
        $middleware->api(append: [
            'jwtAuth'
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (ValidationException $e, Request $request) {
            $response = new ApiResponseService();
            if ($request->is('api/*')) {
                return $response->error(
                    'Erro interno do servidor',
                    ['exception' => $e->getMessage()],
                    400
                );
            }

            return false;
        });
        $exceptions->render(function (AuthenticationException $exception) {
            $response = new ApiResponseService();
            return $response->error(
                'Erro de autorização',
                ['exception' => $exception->getMessage()],
                401
            );
        });
        $exceptions->render(function (QueryException $e, Request $request) {
            $response = new ApiResponseService();
            if ($request->is('api/*')) {
                return $response->error(
                    'Erro interno do servidor',
                    ['exception' => $e->getMessage()],
                    500
                );
            }

            return false;
        });
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            $response = new ApiResponseService();
            if ($request->is('api/*')) {
                return $response->error(
                    'Erro interno do servidor',
                    ['exception' => $e->getMessage()],
                    404
                );
            }

            return false;
        });
        $exceptions->render(function (AccessDeniedHttpException $e, Request $request) {
            $response = new ApiResponseService();
            if ($request->is('api/*')) {
                return $response->error(
                    'Erro de permissão',
                    ['exception' => $e->getMessage()],
                    403
                );
            }

            return false;
        });
        $exceptions->render(function (HttpException $e, Request $request) {
            $response = new ApiResponseService();
            if ($request->is('api/*')) {
                return $response->error(
                    'Erro de permissão',
                    ['exception' => $e->getMessage()],
                    401
                );
            }

            return false;
        });
    })->create();
