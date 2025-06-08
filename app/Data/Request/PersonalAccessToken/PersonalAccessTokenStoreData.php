<?php

declare(strict_types=1);

namespace App\Data\Request\PersonalAccessToken;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Data;

final class PersonalAccessTokenStoreData extends Data
{
    #[Min(3), Max(255)]
    public string $name;

    /**
     * @return array<string, array<int, string|Unique>>
     */
    public static function rules(): array
    {
        /** @var User $user */
        $user = auth()->user();

        return [
            'name' => [
                'required',
                Rule::unique('personal_access_tokens', 'name')
                    ->where('tokenable_id', $user->id),
            ],
        ];
    }
}
