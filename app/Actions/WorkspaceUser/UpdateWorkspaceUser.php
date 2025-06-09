<?php

declare(strict_types=1);

namespace App\Actions\WorkspaceUser;

use App\Data\Transfer\WorkspaceUser\WorkspaceUserData;
use App\Models\WorkspaceUser;
use Lorisleiva\Actions\Concerns\AsAction;

final class UpdateWorkspaceUser
{
    use AsAction;

    public function handle(WorkspaceUser $workspaceUser, WorkspaceUserData $data): WorkspaceUser
    {
        return tap(
            $workspaceUser,
            fn (WorkspaceUser $workspaceUser) => $workspaceUser->update($data->toArray()),
        );
    }
}
