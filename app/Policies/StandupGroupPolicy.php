<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\StandupGroup;
use App\Models\User;

final class StandupGroupPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, StandupGroup $standupGroup): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, StandupGroup $standupGroup): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, StandupGroup $standupGroup): bool
    {
        return false;
    }
}
