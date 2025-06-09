<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use App\Models\WorkspaceUser;

final class WorkspaceUserPolicy
{
    public function view(User $user, WorkspaceUser $workspaceUser): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, WorkspaceUser $workspaceUser): bool
    {
        return false;
    }

    public function delete(User $user, WorkspaceUser $workspaceUser): bool
    {
        return false;
    }
}
