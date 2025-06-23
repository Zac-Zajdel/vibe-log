<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\User\StoreUser;
use App\Actions\User\UpdateUser;
use App\Actions\Workspace\StoreWorkspace;
use App\Data\Request\User\UserIndexData;
use App\Data\Request\User\UserStoreData;
use App\Data\Request\User\UserUpdateData;
use App\Data\Resource\User\UserResource;
use App\Data\Transfer\User\UserData;
use App\Data\Transfer\Workspace\WorkspaceData;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\PaginatedDataCollection;
use Symfony\Component\HttpFoundation\Response;

final class UserController extends Controller
{
    public function index(UserIndexData $data): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        // TODO:Laravel Query Builder.
        // TODO: - Search, Filter, Sort, and Relationship enums.

        $users = User::query()
            ->whereHas(
                'workspaces',
                /** @param Builder<\App\Models\WorkspaceUser> */
                fn (Builder $q) => $q->whereWorkspaceId($user->active_workspace_id),
            )
            ->paginate(
                perPage: ! $data->per_page instanceof Optional ? $data->per_page : 10,
                page: ! $data->page instanceof Optional ? $data->page : 1,
            );

        return $this->success(
            UserResource::collect($users, PaginatedDataCollection::class),
            'Users retrieved successfully',
        );
    }

    public function store(UserStoreData $data): JsonResponse
    {
        $user = StoreUser::make()->handle(UserData::from($data));

        $workspace = StoreWorkspace::make()->handle(
            WorkspaceData::from([
                'owner_id' => $user->id,
                'name' => 'Default Workspace',
                'description' => 'Your personal workspace',
                'is_default' => true,
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

    /**
     * @throws AuthorizationException
     */
    public function update(User $user, UserUpdateData $data): JsonResponse
    {
        Gate::authorize('update', $user);

        $user = UpdateUser::make()->handle(
            $user,
            UserData::from($data),
        );

        return $this->success(
            UserResource::from($user->load('activeWorkspace')),
            'User updated successfully',
        );
    }
}
