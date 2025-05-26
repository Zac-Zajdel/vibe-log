<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\User\StoreUser;
use App\Data\Request\User\UserStoreData;
use App\Data\Transfer\User\UserData;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

final class RegisteredUserController extends Controller
{
    public function store(UserStoreData $data): JsonResponse
    {
        $user = StoreUser::make()->handle(UserData::from($data));

        event(new Registered($user));

        Auth::login($user);

        return response()->json([
            'message' => 'User created successfully',
            'data' => $user,
        ]);
    }
}
