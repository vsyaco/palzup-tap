<?php

use App\Http\Controllers\ScoreController;
use App\Http\Controllers\TelegramUserController;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Micromagicman\TelegramWebApp\Facade\TelegramFacade;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
        then: function () {
            Route::post('/scores', [ScoreController::class, 'update'])->name('scores.update');
            Route::get('/scores', [ScoreController::class, 'index'])->name('scores.index');
            Route::get('/telegram_user/{telegram_id}', [TelegramUserController::class, 'show'])->name('telegram_user.show');
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
