<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Middleware bawaan web kamu tetap aman di sini
        $middleware->web(append: [
            \App\Http\Middleware\SetLocale::class,
        ]);

        // 🟩 TAMBAHKAN ALIAS BARU DI SINI
        $middleware->alias([
            'role.not.customer' => \App\Http\Middleware\RoleNotCustomer::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();