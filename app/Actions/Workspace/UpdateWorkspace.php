<?php

declare(strict_types=1);

namespace App\Actions\Workspace;

use App\Data\Transfer\Workspace\WorkspaceData;
use App\Models\Workspace;
use Lorisleiva\Actions\Concerns\AsAction;

final class UpdateWorkspace
{
    use AsAction;

    public function handle(Workspace $workspace, WorkspaceData $data): Workspace
    {
        return tap(
            $workspace,
            fn (Workspace $workspace) => $workspace->update($data->toArray()),
        );
    }
}
