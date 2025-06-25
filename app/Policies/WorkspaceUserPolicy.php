<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use App\Models\Workspace;
use App\Models\WorkspaceUser;
use Illuminate\Auth\Access\Response;

final class WorkspaceUserPolicy
{
    public function delete(User $user, WorkspaceUser $workspaceUser, Workspace $workspace): bool|Response
    {
        if ($workspace->owner_id === $user->id && $workspaceUser->user_id === $user->id) {
            return Response::deny('You cannot leave the workspace you own.');
        }

        if ($workspaceUser->joined_at) {
            return Response::deny('For historical tracking, joined users can only be disabled.');
        }

        return true;
    }
}
