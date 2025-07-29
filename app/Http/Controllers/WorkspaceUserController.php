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
        $workspaceUsers = WorkspaceUser::query()
            ->with([
                'user',
                'workspace',
            ])
            ->whereWorkspaceId(activeWorkspace()->id)
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

    public function store(WorkspaceUserStoreData $data): JsonResponse
    {
        Gate::authorize('store', WorkspaceUser::class);

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

    public function update(WorkspaceUser $workspaceUser, WorkspaceUserUpdateData $data): JsonResponse
    {
        Gate::authorize('update', $workspaceUser);

        $workspaceUser = UpdateWorkspaceUser::make()->handle(
            $workspaceUser,
            WorkspaceUserData::from($data),
        );

        return $this->success(
            WorkspaceUserResource::from($workspaceUser),
            'Workspace user updated successfully',
        );
    }

    public function destroy(WorkspaceUser $workspaceUser): JsonResponse
    {
        Gate::authorize('delete', $workspaceUser);

        $user = $workspaceUser->user;
        $workspace = $workspaceUser->workspace;

        $message = match (true) {
            ! $workspaceUser->joined_at => "Successfully rejected the invitation to join workspace {$workspace->name}.",
            $user->id === $workspaceUser->user_id => "Successfully left workspace {$workspace->name}.",
            default => "Removed user from workspace {$workspace->name}.",
        };

        // A user must always have an active workspace so we circle back to their default.
        if ($user->active_workspace_id === $workspace->id) {
            $user->activeWorkspace()->associate($user->defaultWorkspace);
            $user->save();
        }

        $workspaceUser->delete();

        return $this->success(
            message: $message,
            code: Response::HTTP_NO_CONTENT,
        );
    }
}
