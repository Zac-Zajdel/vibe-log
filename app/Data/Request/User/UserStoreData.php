<?php

declare(strict_types=1);

namespace App\Data\Request\User;

use App\Models\User;
use Illuminate\Validation\Rules\Password;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

final class UserStoreData extends Data
{
    #[Max(255)]
    public string $name;

    #[Email, Max(255), Unique(User::class, 'email')]
    public string $email;

    public string $password;

    /**
     * @return array<string, mixed>
     */
    public static function rules(ValidationContext $context): array
    {
        return [
            'password' => [
                'required',
                'confirmed',
                Password::defaults(),
            ],
        ];
    }
}
