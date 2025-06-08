<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\StandupGroup;
use App\Models\StandupUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StandupUser>
 */
final class StandupUserFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'standup_group_id' => StandupGroup::factory(),
            'user_id' => User::factory(),
            'is_active' => fake()->boolean(),
        ];
    }
}
