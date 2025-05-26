<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;

final class UserPolicy
{
    public function view(User $user, User $model): bool
    {
        return $user->id === $model->id;
    }

    public function update(User $user, User $model): bool
    {
        return $user->id === $model->id;
    }
}
