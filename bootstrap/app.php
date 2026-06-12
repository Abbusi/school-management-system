<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: [
            __DIR__.'/../routes/web.php',
            __DIR__.'/../routes/website.php',
        ],
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Append Language middleware to the web group
        $middleware->appendToGroup('web', \App\Http\Middleware\Language::class);
        $middleware->appendToGroup('web', \App\Http\Middleware\HandleInertiaRequests::class);

        // Define the frontend middleware group
        $middleware->appendToGroup('frontend', \App\Http\Middleware\Frontend::class);

        // Register custom route middleware aliases
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'permission' => \App\Http\Middleware\PermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );

        // Custom exception renderer for backward compatibility
        $exceptions->render(function (\Throwable $exception, Request $request) {
            if (method_exists($exception, 'getStatusCode')) {
                $statusCode = $exception->getStatusCode();

                if (!env('APP_DEBUG', false)) {
                    if (!$request->user() && \App\Http\Helpers\AppHelper::isFrontendEnabled()) {
                        $locale = \Illuminate\Support\Facades\Session::get('user_locale');
                        \Illuminate\Support\Facades\App::setLocale($locale);

                        if ($statusCode == 404) {
                            return response()->view('errors.front_404', [], 404);
                        }

                        if ($statusCode == 500) {
                            return response()->view('errors.front_500', [], 500);
                        }
                    }
                }

                if ($request->user()) {
                    if ($statusCode == 404) {
                        return response()->view('errors.back_404', [], 404);
                    }

                    if ($statusCode == 401) {
                        return response()->view('errors.back_401', [], 404);
                    }
                }
            }
        });
    })->create();
