<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\WorkspaceUser\StoreWorkspaceUser;
use App\Actions\WorkspaceUser\UpdateWorkspaceUser;
use App\Data\Request\WorkspaceUser\WorkspaceUserIndexData;
use App\Data\Request\WorkspaceUser\WorkspaceUserStoreData;
use App\Data\Request\WorkspaceUser\WorkspaceUserUpdateData;
use App\Data\Resource\WorkspaceUser\WorkspaceUserResource;
use App\Data\Transfer\WorkspaceUser\WorkspaceUserData;
use App\Models\User;
use App\Models\Workspace;
use App\Models\WorkspaceUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\PaginatedDataCollection;
use Symfony\Component\HttpFoundation\Response;

final class WorkspaceUserController extends Controller
{
    public function index(WorkspaceUserIndexData $data): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        $workspaceUsers = WorkspaceUser::query()
            ->with([
                'user',
                'workspace',
            ])
            ->whereWorkspaceId($user->active_workspace_id)
            ->when(
                ! $data->search instanceof Optional,
                /** @param Builder<WorkspaceUser> $query */
                fn (Builder $query) => $query->search($data->search),
            )
            ->paginate(
                perPage: ! $data->per_page instanceof Optional ? $data->per_page : 10,
                page: ! $data->page instanceof Optional ? $data->page : 1,
            );

        return $this->success(
            WorkspaceUserResource::collect($workspaceUsers, PaginatedDataCollection::class),
            'Workspace users retrieved successfully',
        );
    }

    public function store(Workspace $workspace, WorkspaceUserStoreData $data): JsonResponse
    {
        Gate::allowIf(fn (User $user) => $user->id === $workspace->owner_id && ! $workspace->is_default);

        /** @var User $addingUser */
        $addingUser = User::whereEmail($data->email)->first();

        $workspaceUser = StoreWorkspaceUser::make()->handle(
            WorkspaceUserData::from([
                ...$data->toArray(),
                'user_id' => $addingUser->id,
            ]),
        );

        return $this->success(
            WorkspaceUserResource::from($workspaceUser),
            'Request sent to user to join the workspace',
            Response::HTTP_CREATED,
        );
    }

    public function update(Workspace $workspace, WorkspaceUser $workspaceUser, WorkspaceUserUpdateData $data): JsonResponse
    {
        Gate::allowIf(fn (User $user) => ($user->id === $workspace->owner_id || $user->id === $workspaceUser->user_id) && ! $workspace->is_default);

        $workspaceUser = UpdateWorkspaceUser::make()->handle(
            $workspaceUser,
            WorkspaceUserData::from($data),
        );

        return $this->success(
            WorkspaceUserResource::from($workspaceUser),
            'Workspace user updated successfully',
        );
    }

    public function destroy(Workspace $workspace, WorkspaceUser $workspaceUser): JsonResponse
    {
        Gate::authorize('delete', [$workspaceUser, $workspace]);

        $workspaceUser->delete();

        return $this->success(
            message: "User has left the workspace {$workspace->name}.",
            code: Response::HTTP_NO_CONTENT,
        );
    }
}
