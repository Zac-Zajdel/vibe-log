<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\User\StoreUser;
use App\Actions\Workspace\StoreWorkspace;
use App\Data\Request\User\UserStoreData;
use App\Data\Transfer\User\UserData;
use App\Data\Transfer\Workspace\WorkspaceData;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

final class RegisteredUserController extends Controller
{
    public function store(UserStoreData $data): JsonResponse
    {
        $user = StoreUser::make()->handle(UserData::from($data));

        $workspace = StoreWorkspace::make()->handle(
            WorkspaceData::from([
                'owner_id' => $user->id,
                'name' => 'Default Workspace',
                'description' => 'Your personal workspace',
            ]),
        );

        $user->activeWorkspace()->associate($workspace);
        $user->save();

        event(new Registered($user));

        Auth::login($user);

        return response()->json([
            'message' => 'User created successfully',
            'data' => $user,
        ]);
    }
}
