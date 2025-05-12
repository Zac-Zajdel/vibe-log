<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Data\Request\User\UserStoreData;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

final class RegisteredUserController extends Controller
{
    public function store(UserStoreData $data): JsonResponse
    {
        $user = User::create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => Hash::make($data->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return response()->json([
            'message' => 'User created successfully',
            'data' => $user,
        ]);
    }
}
