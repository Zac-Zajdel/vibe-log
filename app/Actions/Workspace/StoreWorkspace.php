<?php

declare(strict_types=1);

namespace App\Actions\Workspace;

use App\Data\Transfer\Workspace\WorkspaceData;
use App\Models\Workspace;
use Lorisleiva\Actions\Concerns\AsAction;

final class StoreWorkspace
{
    use AsAction;

    public function handle(WorkspaceData $data): Workspace
    {
        return Workspace::create($data->toArray());
    }
}
