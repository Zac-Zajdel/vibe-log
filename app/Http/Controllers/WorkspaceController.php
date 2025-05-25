<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Workspace\StoreWorkspace;
use App\Data\Request\Workspace\WorkspaceStoreData;
use App\Data\Resource\Workspace\WorkspaceResource;
use App\Data\Transfer\Workspace\WorkspaceData;
use App\Models\Workspace;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;
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
        $workspaces = Workspace::query()
            ->with('user')
            ->whereUserId(request()->user()->id)
            ->paginate(
                perPage: request()->get('per_page', 2),
                page: request()->get('page', 1),
            );

        return $this->success(
            WorkspaceResource::collect($workspaces, PaginatedDataCollection::class)->wrap('workspaces'),
            'Workspaces retrieved successfully'
        );
    }

    public function store(WorkspaceStoreData $data): JsonResponse
    {
        $workspace = StoreWorkspace::make()->handle(
            new WorkspaceData(
                user_id: $data->user_id,
                name: $data->name,
                description: $data->description,
                logo: $data->logo,
            ),
        );

        return $this->success(
            WorkspaceResource::from($workspace),
            'Workspace created successfully',
            Response::HTTP_CREATED,
        );
    }

    public function show(Workspace $workspace): JsonResponse
    {
        return $this->success(
            WorkspaceResource::from($workspace),
            'Workspace retrieved successfully',
        );
    }

    public function update(Workspace $workspace, Request $request): JsonResponse
    {
        Gate::authorize('update', $workspace);

        $workspace->update($request->all());

        return $this->success(
            WorkspaceResource::from($workspace),
            'Workspace updated successfully',
        );
    }

    public function destroy(Workspace $workspace): JsonResponse
    {
        Gate::authorize('delete', $workspace);

        $workspace->delete();

        return $this->success(
            WorkspaceResource::from($workspace),
            'Workspace deleted successfully',
            Response::HTTP_NO_CONTENT,
        );
    }
}
