<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Data\Transfer\User\UserData;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Lorisleiva\Actions\Concerns\AsAction;
use Spatie\LaravelData\Optional;

final class StoreUser
{
    use AsAction;

    public function handle(UserData $data): User
    {
        return tap(
            User::create([
                'name' => $data->name,
                'email' => $data->email,
                'password' => ! $data->password instanceof Optional ? Hash::make($data->password) : null,
            ]),
            fn (User $user) => $user->refresh(),
        );
    }
}
