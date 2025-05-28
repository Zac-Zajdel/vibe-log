<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Data\Resource\User\UserResource;
use App\Models\User;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class AuthenticatedSessionController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            /** @var User $user */
            $user = Auth::user();

            return $this->success(
                UserResource::from($user->load('activeWorkspace')),
                'User logged in successfully',
            );
        }

        return $this->error(
            message: 'The provided credentials do not match our records.',
            code: Response::HTTP_UNPROCESSABLE_ENTITY,
        );
    }

    public function destroy(Request $request): JsonResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return $this->success(
            message: 'User logged out successfully',
        );
    }
}
