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
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

final class UserController extends Controller
{
    public function index(): void
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
            UserResource::from($user->load('activeWorkspace')),
            'User created successfully',
            Response::HTTP_CREATED,
        );
    }

    /**
     * @throws AuthorizationException
     */
    public function show(User $user): JsonResponse
    {
        Gate::authorize('view', $user);

        return $this->success(
            UserResource::from($user->load('activeWorkspace')),
            'User retrieved successfully',
        );
    }

    public function update(Request $request, User $user): void
    {
        Gate::authorize('update', $user);
    }
}
