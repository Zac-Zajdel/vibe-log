<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\Workspace\WorkspaceUserRole;
use App\Models\User;
use App\Models\WorkspaceUser;
use Illuminate\Auth\Access\Response;

final class WorkspaceUserPolicy
{
    public function store(User $user): bool|Response
    {
        $workspace = activeWorkspace();

        if ($workspace->is_default) {
            return Response::deny('Default workspaces cannot have users added.');
        }

        $workspaceUser = $user->workspaceUsers()->whereBelongsTo($workspace)->value('role');
        if ($workspaceUser !== WorkspaceUserRole::ADMIN) {
            return Response::deny('Only admins can add users.');
        }

        return true;
    }

    public function update(User $user, WorkspaceUser $workspaceUser): bool|Response
    {
        if ($workspaceUser->role !== WorkspaceUserRole::ADMIN && $workspaceUser->user_id !== $user->id) {
            return Response::deny('Only admins can update other users.');
        }

        return $user->active_workspace_id === $workspaceUser->workspace_id;
    }

    public function delete(User $user, WorkspaceUser $workspaceUser): bool|Response
    {
        if ($workspaceUser->user_id === $user->id && $workspaceUser->workspace->owner_id === $user->id) {
            return Response::deny('You cannot leave a workspace you own.');
        }

        if (! $workspaceUser->joined_at || $user->id === $workspaceUser->user_id) {
            return true;
        }

        $workspaceUserRole = $user
            ->workspaceUsers()
            ->whereWorkspaceId($workspaceUser->workspace_id)
            ->value('role');

        if ($workspaceUserRole !== WorkspaceUserRole::ADMIN) {
            return Response::deny('Only admins can remove users.');
        }

        return true;
    }
}
