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
    ->withMiddleware(function (Middleware $middleware) {
        
        // Middleware 'role' Anda yang sudah ada
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);

        // Tambahkan baris ini untuk mencegah caching halaman
        $middleware->web(append: [
            \App\Http\Middleware\PreventBackHistory::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();