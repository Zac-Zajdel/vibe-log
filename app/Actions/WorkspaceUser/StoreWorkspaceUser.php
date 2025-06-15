<?php

declare(strict_types=1);

namespace App\Actions\WorkspaceUser;

use App\Data\Transfer\WorkspaceUser\WorkspaceUserData;
use App\Models\WorkspaceUser;
use Lorisleiva\Actions\Concerns\AsAction;

final class StoreWorkspaceUser
{
    use AsAction;

    public function handle(WorkspaceUserData $data): WorkspaceUser
    {
        return tap(
            WorkspaceUser::create($data->toArray()),
            fn (WorkspaceUser $workspaceUser) => $workspaceUser->refresh(),
        );
    }
}
