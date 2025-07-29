<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Workspace\StoreWorkspace;
use App\Actions\Workspace\UpdateWorkspace;
use App\Data\Request\Workspace\WorkspaceIndexData;
use App\Data\Request\Workspace\WorkspaceStoreData;
use App\Data\Request\Workspace\WorkspaceUpdateData;
use App\Data\Resource\Workspace\WorkspaceResource;
use App\Data\Transfer\Workspace\WorkspaceData;
use App\Enums\Workspace\WorkspaceUserStatus;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\PaginatedDataCollection;
use Symfony\Component\HttpFoundation\Response;

final class WorkspaceController extends Controller
{
    public function index(WorkspaceIndexData $data): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        $workspaces = Workspace::query()
            ->where('id', '!=', $user->active_workspace_id)
            ->whereHas(
                'workspaceUsers',
                /** @param Builder<\App\Models\WorkspaceUser> $query */
                fn (Builder $query) => $query->whereUserId($user->id)->whereStatus(WorkspaceUserStatus::ACTIVE),
            )
            ->when(
                ! $data->search instanceof Optional,
                fn ($q) => $q->search($data),
            )
            ->orderBy('name', 'asc')
            ->paginate(
                perPage: $data->per_page,
                page: $data->page,
            );

        return $this->success(
            WorkspaceResource::collect($workspaces, PaginatedDataCollection::class),
            'Workspaces retrieved successfully',
        );
    }

    public function store(WorkspaceStoreData $data): JsonResponse
    {
        $workspace = StoreWorkspace::make()->handle(
            WorkspaceData::from($data),
        );

        return $this->success(
            WorkspaceResource::from($workspace),
            'Workspace created successfully',
            Response::HTTP_CREATED,
        );
    }

    /**
     * @throws AuthorizationException
     */
    public function show(Workspace $workspace): JsonResponse
    {
        Gate::authorize('view', $workspace);

        return $this->success(
            WorkspaceResource::from($workspace->load('owner')),
            'Workspace retrieved successfully',
        );
    }

    /**
     * @throws AuthorizationException
     */
    public function update(Workspace $workspace, WorkspaceUpdateData $data): JsonResponse
    {
        Gate::authorize('update', $workspace);

        $workspace = UpdateWorkspace::make()->handle(
            $workspace,
            WorkspaceData::from($data),
        );

        return $this->success(
            WorkspaceResource::from($workspace),
            'Workspace updated successfully',
        );
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(Workspace $workspace): JsonResponse
    {
        Gate::authorize('delete', $workspace);

        DB::transaction(function () use ($workspace) {
            $workspace
                ->activeWorkspaceUsers()
                ->with('defaultWorkspace')
                ->each(function (User $user) {
                    $user->activeWorkspace()->associate($user->defaultWorkspace);
                    $user->save();
                });

            $workspace->workspaceUsers()->delete();

            $workspace->delete();
        });

        return $this->success(
            message: 'Workspace deleted successfully',
            code: Response::HTTP_NO_CONTENT,
        );
    }
}
