<?php

declare(strict_types=1);

use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\RegisteredUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')
    ->middleware('auth')
    ->group(function (): void {
        Route::get('user', function (Request $request) {
            return response()->json([
                'message' => 'User logged in successfully',
                'data' => $request->user(),
            ]);
        });

        Route::get('hello', function () {
            return response()->json([
                'message' => 'Hello World',
            ]);
        });

        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('logout');
    });

Route::prefix('v1')
    ->middleware('guest')->group(function (): void {
        Route::post('register', [RegisteredUserController::class, 'store']);
        Route::post('login', [AuthenticatedSessionController::class, 'store']);
    });
