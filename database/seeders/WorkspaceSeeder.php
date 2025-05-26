<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use App\Models\Workspace;
use Illuminate\Database\Seeder;

final class WorkspaceSeeder extends Seeder
{
    public function run(): void
    {
        foreach (User::all() as $user) {
            Workspace::factory(2)
                ->for($user, 'owner')
                ->create();
        }
    }
}
