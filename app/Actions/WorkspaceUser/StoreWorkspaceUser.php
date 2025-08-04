<?php

declare(strict_types=1);

namespace App\Actions\WorkspaceUser;

use App\Data\Transfer\WorkspaceUser\WorkspaceUserData;
use App\Models\WorkspaceUser;
use Lorisleiva\Actions\Concerns\AsAction;
use Spatie\LaravelData\Optional;

final class StoreWorkspaceUser
{
    use AsAction;

    public function handle(WorkspaceUserData $data): WorkspaceUser
    {
        $workspaceId = ! $data->workspace_id instanceof Optional
            ? $data->workspace_id
            : activeWorkspace()->id;

        return tap(
            WorkspaceUser::create([
                ...$data->toArray(),
                'workspace_id' => $workspaceId,
            ]),
            fn (WorkspaceUser $workspaceUser) => $workspaceUser->refresh(),
        );
    }
}
