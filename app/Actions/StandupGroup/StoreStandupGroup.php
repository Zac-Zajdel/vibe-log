<?php

declare(strict_types=1);

namespace App\Actions\StandupGroup;

use App\Data\Transfer\StandupGroup\StandupGroupData;
use App\Models\StandupGroup;
use Lorisleiva\Actions\Concerns\AsAction;

final class StoreStandupGroup
{
    use AsAction;

    public function handle(StandupGroupData $data): StandupGroup
    {
        return tap(
            StandupGroup::create($data->toArray()),
            fn (StandupGroup $standupGroup) => $standupGroup->refresh(),
        );
    }
}
