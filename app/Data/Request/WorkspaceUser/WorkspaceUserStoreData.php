<?php

declare(strict_types=1);

namespace App\Data\Request\WorkspaceUser;

use App\Models\User;
use App\Models\Workspace;
use Closure;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;
use Spatie\LaravelData\Attributes\FromRouteParameterProperty;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;
use Spatie\TypeScriptTransformer\Attributes\Hidden;

final class WorkspaceUserStoreData extends Data
{
    #[Hidden, Exists(Workspace::class, 'id'), FromRouteParameterProperty('workspace', 'id')]
    public int $workspace_id;

    public string $email;

    /**
     * @return array<string, array<int, string|Unique|\Illuminate\Validation\Rules\Exists|Closure>>
     */
    public static function rules(ValidationContext $context): array
    {
        return [
            'email' => [
                'required',
                Rule::exists(User::class, 'email'),
                function (string $attribute, $value, Closure $fail) use ($context) {
                    $user = User::whereEmail($value)->first();

                    if (! $user) {
                        $fail('The user with this email does not exist.');
                    }

                    if ($user?->workspaces()->where('workspace_id', $context->payload['workspace_id'])->exists()) {
                        $fail('The user already belongs to this workspace.');
                    }
                },
            ],
        ];
    }
}
