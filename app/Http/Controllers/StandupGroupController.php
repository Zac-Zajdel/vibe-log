<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\StandupGroup\StoreStandupGroup;
use App\Actions\StandupGroup\UpdateStandupGroup;
use App\Data\Request\StandupGroup\StandupGroupIndexData;
use App\Data\Request\StandupGroup\StandupGroupStoreData;
use App\Data\Request\StandupGroup\StandupGroupUpdateData;
use App\Data\Resource\StandupGroup\StandupGroupResource;
use App\Data\Transfer\StandupGroup\StandupGroupData;
use App\Models\StandupGroup;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\PaginatedDataCollection;
use Symfony\Component\HttpFoundation\Response;

final class StandupGroupController extends Controller
{
    public function index(StandupGroupIndexData $data): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        $standupGroups = StandupGroup::query()
            ->where('workspace_id', $user->active_workspace_id)
            ->paginate(
                perPage: ! $data->per_page instanceof Optional ? $data->per_page : 10,
                page: ! $data->page instanceof Optional ? $data->page : 1,
            );

        return $this->success(
            StandupGroupResource::collect($standupGroups, PaginatedDataCollection::class),
            'Standup Groups retrieved successfully',
        );
    }

    public function store(StandupGroupStoreData $data): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        $standupGroup = StoreStandupGroup::make()->handle(
            StandupGroupData::from([
                ...$data->toArray(),
                'workspace_id' => $user->active_workspace_id,
            ]),
        );

        return $this->success(
            StandupGroupResource::from($standupGroup),
            'Standup Group created successfully',
            Response::HTTP_CREATED,
        );
    }

    /**
     * @throws AuthorizationException
     */
    public function show(StandupGroup $standupGroup): JsonResponse
    {
        Gate::authorize('view', $standupGroup);

        return $this->success(
            StandupGroupResource::from($standupGroup->load('owner')),
            'Standup Group retrieved successfully',
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
            StandupGroupResource::from($standupGroup),
            'Standup Group updated successfully',
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
            message: 'Standup Group deleted successfully',
            code: Response::HTTP_NO_CONTENT,
        );
    }
}
