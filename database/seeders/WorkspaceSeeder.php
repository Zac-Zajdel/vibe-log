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
        Workspace::factory(2)
            ->for(User::first(), 'owner')
            ->create();
    }
}
