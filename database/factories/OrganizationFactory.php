<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Organization>
 */
final class OrganizationFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->company();

        return [
            'owner_id' => User::factory(),
            'name' => $name,
            'slug' => Str::slug($name),
            'avatar' => fake()->imageUrl(),
            'description' => fake()->sentence(),
        ];
    }
}
