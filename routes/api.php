<?php

declare(strict_types=1);

use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\WorkspaceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')
    ->middleware('auth')
    ->group(function (): void {
        Route::get('user', fn (Request $request) => response()->json([
            'status' => 'success',
            'message' => 'User logged in successfully',
            'data' => $request->user(),
        ]));

        Route::get('hello', fn () => response()->json([
            'status' => 'success',
            'message' => 'Retrieved successfully',
            'data' => 'Hello World',
        ]));

        Route::apiResource('workspaces', WorkspaceController::class);

        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    });

Route::prefix('v1')
    ->middleware('guest')->group(function (): void {
        Route::post('register', [RegisteredUserController::class, 'store']);
        Route::post('login', [AuthenticatedSessionController::class, 'store']);
    });
