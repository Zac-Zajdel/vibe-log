<?php

declare(strict_types=1);

namespace App\Actions\WorkspaceUser;

use App\Data\Transfer\WorkspaceUser\WorkspaceUserData;
use App\Enums\Workspace\WorkspaceUserRole;
use App\Enums\Workspace\WorkspaceUserStatus;
use App\Models\WorkspaceUser;
use Lorisleiva\Actions\Concerns\AsAction;
use Spatie\LaravelData\Optional;

final class UpdateWorkspaceUser
{
    use AsAction;

    public function handle(WorkspaceUser $workspaceUser, WorkspaceUserData $data): WorkspaceUser
    {
        $workspaceUser = $this->adminOnlyUpdates($workspaceUser, $data);
        $workspaceUser = $this->acceptInvitation($workspaceUser);

        // Only the same user can update their metadata.
        if ($workspaceUser->user_id === auth()->id()) {
            $workspaceUser->fill(collect($data)->only(['avatar', 'username'])->all());
        }

        $workspaceUser->save();

        return $workspaceUser;
    }

    /**
     * Only admins can update a user's role and if already joined, their status.
     */
    private function adminOnlyUpdates(
        WorkspaceUser $workspaceUser,
        WorkspaceUserData $data,
    ): WorkspaceUser {
        $userRole = auth()->user()->workspaceUsers()->whereWorkspaceId($workspaceUser->workspace_id)->value('role');

        if ($userRole === WorkspaceUserRole::ADMIN) {
            if (! $data->role instanceof Optional) {
                $workspaceUser->role = $data->role;
            }
            if (! $data->status instanceof Optional && $workspaceUser->joined_at) {
                $workspaceUser->status = $data->status;
            }
        }

        return $workspaceUser;
    }

    /**
     * Non-admins can only set their own status to ACTIVE when they accept an invitation.
     */
    private function acceptInvitation(WorkspaceUser $workspaceUser): WorkspaceUser
    {
        if (
            $workspaceUser->user_id === auth()->id() &&
            $workspaceUser->status === WorkspaceUserStatus::INVITED &&
            ! $workspaceUser->joined_at
        ) {
            $workspaceUser->status = WorkspaceUserStatus::ACTIVE;
            $workspaceUser->joined_at = now();
        }

        return $workspaceUser;
    }
}
