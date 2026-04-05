<?php

use App\Http\Middleware\RoleMiddleware;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->statefulApi();
        $middleware->alias([
            'role' => RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        // 1. Validation errors (422)
        $exceptions->render(function (ValidationException $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Validation Failed',
                'errors'  => $e->errors(),
            ], 422);
        });

        // 2. Authentication errors (401)
        $exceptions->render(function (AuthenticationException $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Unauthenticated',
            ], 401);
        });

        // 3. Authorization errors (403)
        $exceptions->render(function (AuthorizationException|AccessDeniedHttpException $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage() ?: 'This action is unauthorized.',
            ], 403);
        });

        // 4. General Fallback for API
        $exceptions->render(function (\Throwable $e, $request) {
            if ($request->is('api/*')) {
                if ($e instanceof HttpExceptionInterface) {
                    return null;
                }

                return response()->json([
                    'status'  => 'error',
                    'message' => config('app.debug') ? $e->getMessage() : 'Internal Server Error',
                ], 500);
            }
        });
    })->create();
