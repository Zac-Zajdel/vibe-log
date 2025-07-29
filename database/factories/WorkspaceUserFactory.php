<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Workspace\WorkspaceUserRole;
use App\Enums\Workspace\WorkspaceUserStatus;
use App\Models\User;
use App\Models\Workspace;
use App\Models\WorkspaceUser;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<WorkspaceUser>
 */
final class WorkspaceUserFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'workspace_id' => Workspace::factory(),
            'user_id' => User::factory(),
            'username' => fake()->name(),
            'avatar' => fake()->imageUrl(),
            'role' => WorkspaceUserRole::ADMIN,
            'status' => WorkspaceUserStatus::ACTIVE,
            'joined_at' => now(),
        ];
    }

    public function admin(): static
    {
        return $this->state(fn () => [
            'role' => WorkspaceUserRole::ADMIN,
        ]);
    }

    public function member(): static
    {
        return $this->state(fn () => [
            'role' => WorkspaceUserRole::MEMBER,
        ]);
    }

    public function viewer(): static
    {
        return $this->state(fn () => [
            'role' => WorkspaceUserRole::VIEWER,
        ]);
    }

    public function invited(): static
    {
        return $this->state(fn () => [
            'status' => WorkspaceUserStatus::INVITED,
        ]);
    }

    public function active(): static
    {
        return $this->state(fn () => [
            'status' => WorkspaceUserStatus::ACTIVE,
        ]);
    }

    public function disabled(): static
    {
        return $this->state(fn () => [
            'status' => WorkspaceUserStatus::DISABLED,
        ]);
    }
}
