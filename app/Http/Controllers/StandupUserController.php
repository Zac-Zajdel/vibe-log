<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Data\Request\StandupUser\StandupUserStoreData;
use App\Data\Resource\StandupUser\StandupUserResource;
use App\Models\StandupGroup;
use App\Models\StandupUser;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

final class StandupUserController extends Controller
{
    public function index(StandupGroup $standupGroup): void
    {
        Gate::allowIf(fn (User $user) => $user->id === $standupGroup->owner_id);

        // Fetch standup users associated to a standup group.
    }

    public function store(StandupGroup $standupGroup, StandupUserStoreData $data): void
    {
        Gate::allowIf(fn (User $user) => $user->id === $standupGroup->owner_id);

        // logger($data->toArray());

        // Create standup user for standup group.
    }

    /**
     * @throws AuthorizationException
     */
    public function update(StandupGroup $standupGroup, StandupUser $standupUser): JsonResponse
    {
        Gate::authorize('update', $standupGroup);

        // Update active status

        return $this->success(
            StandupUserResource::from($standupUser),
            'Standup User updated successfully',
        );
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(StandupGroup $standupGroup, StandupUser $standupUser): JsonResponse
    {
        Gate::authorize('delete', $standupGroup);

        $standupUser->delete();

        return $this->success(
            message: 'Standup User deleted successfully',
            code: Response::HTTP_NO_CONTENT,
        );
    }
}
