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
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Auth\Access\AuthorizationException;
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
            ->whereOwnerId($user->id)
            ->where('id', '!=', $user->active_workspace_id)
            ->when(
                ! $data->search instanceof Optional,
                fn ($q) => $q->search($data),
            )
            ->orderBy('name', 'asc')
            ->paginate(
                perPage: request()->get('per_page', 10),
                page: request()->get('page', 1),
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

            $workspace->delete();
        });

        return $this->success(
            null,
            'Workspace deleted successfully',
            Response::HTTP_NO_CONTENT,
        );
    }
}
