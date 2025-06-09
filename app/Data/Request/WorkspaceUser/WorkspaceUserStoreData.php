<?php

declare(strict_types=1);

namespace App\Data\Request\WorkspaceUser;

use App\Models\User;
use App\Models\Workspace;
use App\Models\WorkspaceUser;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;
use Spatie\LaravelData\Attributes\FromRouteParameterProperty;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\Support\Validation\ValidationContext;
use Spatie\TypeScriptTransformer\Attributes\Hidden;

final class WorkspaceUserStoreData extends Data
{
    #[Hidden, Exists(Workspace::class, 'id'), FromRouteParameterProperty('workspace', 'id')]
    public int $workspace_id;

    #[Exists(User::class, 'id')]
    public int $user_id;

    public Optional|bool $is_active;

    /**
     * @return array<string, array<int, string|Unique>>
     */
    public static function rules(ValidationContext $context): array
    {
        return [
            'user_id' => [
                'required',
                Rule::unique(WorkspaceUser::class, 'user_id')
                    ->where('workspace_id', $context->payload['workspace_id']),
            ],
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function messages(): array
    {
        return [
            'user_id.unique' => 'This user already belongs to this workspace.',
        ];
    }
}
