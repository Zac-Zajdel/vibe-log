<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use App\Models\Workspace;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Workspace>
 */
final class WorkspaceFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'owner_id' => User::factory(),
            'name' => fake()->unique()->company(),
            'description' => fake()->paragraph(),
            'logo' => fake()->imageUrl(),
        ];
    }

    public function default(): Factory
    {
        return $this->state(fn () => [
            'name' => 'Default Workspace',
            'description' => 'Your personal workspace',
            'is_default' => true,
        ]);
    }
}
