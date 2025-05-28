<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use App\Models\Workspace;
use Illuminate\Auth\Access\Response;

final class WorkspacePolicy
{
    public function view(User $user, Workspace $workspace): bool
    {
        return $user->id === $workspace->owner_id;
    }

    public function update(User $user, Workspace $workspace): bool
    {
        return $user->id === $workspace->owner_id;
    }

    public function delete(User $user, Workspace $workspace): bool|Response
    {
        if ($workspace->is_default) {
            return Response::deny('Your default workspace cannot be deleted.');
        }

        return $user->id === $workspace->owner_id;
    }
}
