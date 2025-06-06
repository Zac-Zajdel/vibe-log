<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\StandupGroup\UpdateStandupGroup;
use App\Data\Request\StandupGroup\StandupGroupUpdateData;
use App\Data\Resource\StandupGroup\StandupGroupResource;
use App\Data\Transfer\StandupGroup\StandupGroupData;
use App\Models\StandupGroup;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

final class StandupGroupController extends Controller
{
    public function index(): void
    {
        //
    }

    public function store(): void
    {
        //
    }

    /**
     * @throws AuthorizationException
     */
    public function show(StandupGroup $standupGroup): JsonResponse
    {
        Gate::authorize('view', $standupGroup);

        return $this->success(
            StandupGroupResource::from($standupGroup->load('owner')),
            'Standup retrieved successfully',
        );
    }

    /**
     * @throws AuthorizationException
     */
    public function update(StandupGroupUpdateData $data, StandupGroup $standupGroup): JsonResponse
    {
        Gate::authorize('update', $standupGroup);

        $standupGroup = UpdateStandupGroup::make()->handle(
            $standupGroup,
            StandupGroupData::from($data),
        );

        return $this->success(
            StandupGroupData::from($standupGroup),
            'Workspace updated successfully',
        );
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(StandupGroup $standupGroup): JsonResponse
    {
        Gate::authorize('delete', $standupGroup);

        $standupGroup->delete();

        return $this->success(
            null,
            'Standup deleted successfully',
            Response::HTTP_NO_CONTENT,
        );
    }
}
