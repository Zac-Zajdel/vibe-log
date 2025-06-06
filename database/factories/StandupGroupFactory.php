<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\StandupGroup\StandupGroupDay;
use App\Enums\StandupGroup\StandupGroupVisibility;
use App\Models\StandupGroup;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StandupGroup>
 */
final class StandupGroupFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'workspace_id' => Workspace::factory(),
            'owner_id' => User::factory(),
            'name' => fake()->jobTitle(),
            'description' => fake()->sentence(),
            'visibility' => collect(StandupGroupVisibility::cases())->random(),
            'is_active' => fake()->boolean(),
            'days' => collect(StandupGroupDay::cases())->random(3)->toArray(),
        ];
    }
}
