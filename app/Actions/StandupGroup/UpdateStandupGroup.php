<?php

declare(strict_types=1);

namespace App\Actions\StandupGroup;

use App\Data\Transfer\StandupGroup\StandupGroupData;
use App\Models\StandupGroup;
use Lorisleiva\Actions\Concerns\AsAction;

final class UpdateStandupGroup
{
    use AsAction;

    public function handle(StandupGroup $standupGroup, StandupGroupData $data): StandupGroup
    {
        return tap(
            $standupGroup,
            fn (StandupGroup $standupGroup) => $standupGroup->update($data->toArray()),
        );
    }
}
