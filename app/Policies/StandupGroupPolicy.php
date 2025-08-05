<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\Workspace\WorkspaceUserRole;
use App\Models\StandupGroup;
use App\Models\User;

final class StandupGroupPolicy
{
    public function view(User $user, StandupGroup $standupGroup): bool
    {
        return $user
            ->workspaceUsers()
            ->whereWorkspaceId($standupGroup->workspace_id)
            ->exists();
    }

    public function store(User $user): bool
    {
        return $user
            ->workspaceUsers()
            ->whereBelongsTo(activeWorkspace())
            ->whereRole(WorkspaceUserRole::ADMIN)
            ->exists();
    }

    public function update(User $user, StandupGroup $standupGroup): bool
    {
        return $user->id === $standupGroup->owner_id;
    }

    public function delete(User $user, StandupGroup $standupGroup): bool
    {
        return $user->id === $standupGroup->owner_id;
    }
}
