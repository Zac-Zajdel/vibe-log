<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\User\StoreUser;
use App\Actions\Workspace\StoreWorkspace;
use App\Data\Request\User\UserStoreData;
use App\Data\Resource\User\UserResource;
use App\Data\Transfer\User\UserData;
use App\Data\Transfer\Workspace\WorkspaceData;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

final class UserController extends Controller
{
    public function index()
    {
        //
    }

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

        return $this->success(
            UserResource::from($user),
            'User created successfully',
            Response::HTTP_CREATED,
        );
    }

    public function show(User $user)
    {
        //
    }

    public function update(Request $request, User $user)
    {
        //
    }

    public function destroy(User $user)
    {
        //
    }
}
