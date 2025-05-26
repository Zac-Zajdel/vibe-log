<?php

declare(strict_types=1);

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->statefulApi();

        // TODO: Remove this when we have Sanctum tokens working for Postman testing...
        // if (env('APP_ENV') === 'local') {
        //     $middleware->append(StartSession::class);
        // }
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (ValidationException $e): JsonResponse {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation Failed',
                'errors' => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        });

        $exceptions->render(function (AuthenticationException $e): JsonResponse {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], Response::HTTP_UNAUTHORIZED);
        });

        $exceptions->render(function (QueryException $e): JsonResponse {
            return response()->json([
                'status' => 'error',
                'message' => 'Database Error Occurred',
                'code' => $e->getCode(),
                'reference' => (string) str()->uuid(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        });

        // Catch-all for unexpected exceptions
        $exceptions->render(function (Throwable $e): JsonResponse {
            report($e->getMessage());

            if (config('app.debug')) {
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage(),
                    'debug' => [
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                        'trace' => $e->getTraceAsString(),
                        'reference' => (string) str()->uuid(),
                    ],
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred',
                'reference' => (string) str()->uuid(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        });
    })->create();
