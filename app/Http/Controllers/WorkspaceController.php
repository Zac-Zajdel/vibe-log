<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Workspace\StoreWorkspace;
use App\Data\Request\Workspace\WorkspaceStoreData;
use App\Data\Transfer\Workspace\WorkspaceData;
use App\Models\Workspace;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpFoundation\Response;

final class WorkspaceController extends Controller
{
    public function index(): void
    {
        //
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
            $workspace,
            'Workspace created successfully',
            Response::HTTP_CREATED,
        );
    }

    public function show(Workspace $workspace): JsonResponse
    {
        return $this->success(
            $workspace,
            'Workspace retrieved successfully',
        );
    }

    public function update(Workspace $workspace, Request $request): JsonResponse
    {
        Gate::authorize('update', $workspace);

        $workspace->update($request->all());

        return $this->success(
            $workspace,
            'Workspace updated successfully',
        );
    }

    public function destroy(Workspace $workspace): JsonResponse
    {
        Gate::authorize('delete', $workspace);

        $workspace->delete();

        return $this->success(
            $workspace,
            'Workspace deleted successfully',
            Response::HTTP_NO_CONTENT,
        );
    }
}
