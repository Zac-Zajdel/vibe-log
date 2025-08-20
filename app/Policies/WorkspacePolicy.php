<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use App\Models\Workspace;
use Illuminate\Auth\Access\Response;

final class WorkspacePolicy
{
    public function view(User $user, Workspace $workspace): Response|bool
    {
        if ($user->active_workspace_id !== $workspace->id) {
            return Response::deny('You must belong to this workspace to view it.');
        }

        return $user->active_workspace_id === $workspace->id;
    }

    public function update(User $user, Workspace $workspace): Response|bool
    {
        if ($user->id !== $workspace->owner_id) {
            return Response::deny('Only workspace owners can update a workspace.');
        }

        return $user->id === $workspace->owner_id;
    }

    public function delete(User $user, Workspace $workspace): Response|bool
    {
        if ($workspace->is_default) {
            return Response::deny('Your default workspace cannot be deleted.');
        }

        if ($user->id !== $workspace->owner_id) {
            return Response::deny('Only workspace owners can delete a workspace.');
        }

        return $user->id === $workspace->owner_id;
    }
}
