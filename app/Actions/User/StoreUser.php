<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Data\Transfer\User\UserData;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Lorisleiva\Actions\Concerns\AsAction;

final class StoreUser
{
    use AsAction;

    public function handle(
        UserData $data,
    ): User {
        return User::create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => $data->password ? Hash::make($data->password) : null,
        ]);
    }
}
