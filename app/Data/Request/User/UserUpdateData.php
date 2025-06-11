<?php

declare(strict_types=1);

namespace App\Data\Request\User;

use App\Models\User;
use App\Models\WorkspaceUser;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\Unique;
use Spatie\LaravelData\Attributes\FromRouteParameterProperty;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\Support\Validation\ValidationContext;
use Spatie\TypeScriptTransformer\Attributes\Hidden;

final class UserUpdateData extends Data
{
    #[Hidden, FromRouteParameterProperty('user', 'id')]
    public int $id;

    #[Max(255)]
    public Optional|string $name;

    public Optional|string $email;

    public Optional|int $active_workspace_id;

    /**
     * @return array<string, list<string|Unique|Exists>>
     */
    public static function rules(ValidationContext $context): array
    {
        return [
            'email' => [
                'max:255',
                'string',
                'email',
                Rule::unique(User::class, 'email')->ignore($context->payload['id']),
            ],
            'active_workspace_id' => [
                Rule::exists(WorkspaceUser::class, 'workspace_id')
                    ->where('user_id', data_get($context->payload, 'id'))
                    ->where('is_active', true),
            ],
        ];
    }
}
