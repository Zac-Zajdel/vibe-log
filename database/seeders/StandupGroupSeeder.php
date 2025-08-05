<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\StandupGroup;
use App\Models\WorkspaceUser;
use Illuminate\Database\Seeder;

final class StandupGroupSeeder extends Seeder
{
    public function run(): void
    {
        $workspaceUser = WorkspaceUser::with('workspace')->first();

        StandupGroup::factory(5)
            ->for($workspaceUser, 'owner')
            ->for($workspaceUser->workspace)
            ->create();
    }
}
