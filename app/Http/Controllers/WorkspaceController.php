<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Workspace\StoreWorkspace;
use App\Actions\Workspace\UpdateWorkspace;
use App\Data\Request\Workspace\WorkspaceStoreData;
use App\Data\Request\Workspace\WorkspaceUpdateData;
use App\Data\Resource\Workspace\WorkspaceResource;
use App\Data\Transfer\Workspace\WorkspaceData;
use App\Models\Workspace;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Spatie\LaravelData\PaginatedDataCollection;
use Symfony\Component\HttpFoundation\Response;

/**
 * 1. Test other routes
 * 2. Create postman collections
 * 3. lang files responses
 * 4. validate policies.
 * 5. test cases.
 * 6. Create default workspace when user is created.
 */
final class WorkspaceController extends Controller
{
    public function index(): JsonResponse
    {
        $collection = Workspace::query()
            ->with('user')
            ->whereUserId(request()->user()?->id)
            ->paginate(
                perPage: request()->get('per_page', 2),
                page: request()->get('page', 1),
            );

        return $this->success(
            WorkspaceResource::collect($collection, PaginatedDataCollection::class)->wrap('workspaces'),
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

        // todo - relationship should be owner.
        return $this->success(
            WorkspaceResource::from($workspace->load('user')),
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

        $workspace->delete();

        return $this->success(
            null,
            'Workspace deleted successfully',
            Response::HTTP_NO_CONTENT,
        );
    }
}
