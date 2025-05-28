<?php

declare(strict_types=1);

use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkspaceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')
    ->middleware('auth')
    ->group(function (): void {
        Route::get('user', fn (Request $request) => response()->json([
            'status' => 'success',
            'message' => 'User logged in successfully',
            'data' => $request->user()->load('activeWorkspace'),
        ]))->name('user.show');

        Route::apiResource('workspaces', WorkspaceController::class);
        Route::apiResource('users', UserController::class)->except(['index', 'show', 'destroy']);

        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    });

Route::prefix('v1')
    ->middleware('guest')->group(function (): void {
        Route::post('register', [UserController::class, 'store'])->name('user.register');
        Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('user.login');
    });
