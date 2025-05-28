<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Data\Transfer\User\UserData;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

final class UpdateUser
{
    use AsAction;

    public function handle(User $user, UserData $data): User
    {
        return tap(
            $user,
            fn (User $user) => $user->update($data->toArray()),
        );
    }
}
