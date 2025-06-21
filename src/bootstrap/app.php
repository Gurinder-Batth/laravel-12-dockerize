<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Get environment name from APP_ENV
$env = env('APP_ENV_FILE', 'local');

// Determine the environment-specific .env file
$envFile = ".env.$env";

// Load the environment file if it exists
$basePath = dirname(__DIR__);
if (file_exists("$basePath/$envFile")) {
    $dotenv = Dotenv\Dotenv::createImmutable($basePath, $envFile);
    $dotenv->safeLoad();
}


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
