<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\StandupGroup;
use App\Models\StandupUser;
use App\Models\User;
use Illuminate\Database\Seeder;

final class StandupGroupSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::with('activeWorkspace')->first();

        StandupGroup::factory(5)
            ->for($user, 'owner')
            ->for($user->activeWorkspace)
            ->has(StandupUser::factory()->for($user), 'users')
            ->create();
    }
}
