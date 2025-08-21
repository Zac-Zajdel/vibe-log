<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Auth\Access\Response;

final class OrganizationPolicy
{
    public function view(User $user, Organization $organization): Response|bool
    {
        // if (! $organization->hasUser($user)) {
        //     return Response::deny('You are not a member of this organization.');
        // }

        return true;
    }

    public function update(User $user, Organization $organization): Response|bool
    {
        if ($user->id !== $organization->owner_id) {
            return Response::deny('You are not the owner of this organization.');
        }

        return true;
    }

    public function delete(User $user, Organization $organization): Response|bool
    {
        if ($user->id !== $organization->owner_id) {
            return Response::deny('You are not the owner of this organization.');
        }

        return true;
    }
}
