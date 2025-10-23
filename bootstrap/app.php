<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->validateCsrfTokens(except: [
            '/pay-via-ajax', '/success','/cancel','/fail','/ipn'
            // 'stripe/*',

            // 'http://example.com/foo/bar',

            // 'http://example.com/foo/*',

        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
