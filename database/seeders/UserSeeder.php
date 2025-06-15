<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

final class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Zac Zajdel',
            'email' => 'zaczajdel213@gmail.com',
            'password' => Hash::make(config('app.seeder_password')),
        ]);

        User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@doe.com',
            'password' => Hash::make(config('app.seeder_password')),
        ]);
    }
}
