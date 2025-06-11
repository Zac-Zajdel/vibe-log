<?php

declare(strict_types=1);

namespace App\Actions\Workspace;

use App\Data\Transfer\Workspace\WorkspaceData;
use App\Models\Workspace;
use App\Models\WorkspaceUser;
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

        WorkspaceUser::create([
            'workspace_id' => $workspace->id,
            'user_id' => $data->owner_id,
            'is_active' => true,
            'joined_at' => now(),
        ]);

        return $workspace;
    }
}
