<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Seeder;

final class OrganizationSeeder extends Seeder
{
    public function run(): void
    {
        foreach (User::all() as $user) {
            Organization::factory()->for($user, 'owner')->create();
        }
    }
}
