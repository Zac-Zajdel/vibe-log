<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\StandupGroup;
use App\Models\User;

final class StandupUserPolicy
{
    public function view(User $user, StandupGroup $standupGroup): bool
    {
        return $user->id === $standupGroup->owner_id;
    }

    public function create(User $user, StandupGroup $standupGroup): bool
    {
        return $user->id === $standupGroup->owner_id;
    }

    public function update(User $user, StandupGroup $standupGroup): bool
    {
        return $user->id === $standupGroup->owner_id;
    }

    public function delete(User $user, StandupGroup $standupGroup): bool
    {
        return $user->id === $standupGroup->owner_id;
    }
}
