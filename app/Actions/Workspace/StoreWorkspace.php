<?php

declare(strict_types=1);

namespace App\Actions\Workspace;

use App\Actions\WorkspaceUser\StoreWorkspaceUser;
use App\Data\Transfer\Workspace\WorkspaceData;
use App\Data\Transfer\WorkspaceUser\WorkspaceUserData;
use App\Enums\Workspace\WorkspaceUserRole;
use App\Enums\Workspace\WorkspaceUserStatus;
use App\Models\User;
use App\Models\Workspace;
use Lorisleiva\Actions\Concerns\AsAction;

final class StoreWorkspace
{
    use AsAction;

    public function handle(WorkspaceData $data): Workspace
    {
        $workspace = tap(
            Workspace::create($data->toArray()),
            fn (Workspace $workspace) => $workspace->refresh(),
        );

        $user = User::find($data->owner_id);

        StoreWorkspaceUser::make()->handle(
            WorkspaceUserData::from([
                'workspace_id' => $workspace->id,
                'user_id' => $data->owner_id,
                'username' => $user->name,
                'role' => WorkspaceUserRole::ADMIN,
                'status' => WorkspaceUserStatus::ACTIVE,
                'joined_at' => now(),
            ]),
        );

        return $workspace;
    }
}
