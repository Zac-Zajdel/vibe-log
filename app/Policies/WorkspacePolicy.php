<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use App\Models\Workspace;

final class WorkspacePolicy
{
    public function update(User $user, Workspace $workspace): bool
    {
        return $user->id === $workspace->user_id;
    }

    public function delete(User $user, Workspace $workspace): bool
    {
        return $user->id === $workspace->user_id;
    }
}
