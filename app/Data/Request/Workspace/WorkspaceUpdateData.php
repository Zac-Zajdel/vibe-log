<?php

declare(strict_types=1);

namespace App\Data\Request\Workspace;

use App\Models\User;
use App\Models\Workspace;
use Illuminate\Validation\Rule;
use Spatie\LaravelData\Attributes\FromRouteParameterProperty;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;
use Spatie\TypeScriptTransformer\Attributes\Hidden;

final class WorkspaceUpdateData extends Data
{
    #[Hidden, FromRouteParameterProperty('workspace', 'id')]
    public int $id;

    #[Exists(User::class, 'id')]
    public int $owner_id;

    #[Min(3), Max(255)]
    public string $name;

    #[Max(1000)]
    public ?string $description;

    #[Max(255)]
    public ?string $logo;

    public ?string $archived_at = null;

    /**
     * @return array<string, mixed>
     */
    public static function rules(ValidationContext $context): array
    {
        return [
            'name' => [
                'required',
                Rule::unique(Workspace::class, 'name')
                    ->where('owner_id', data_get($context->payload, 'owner_id'))
                    ->ignore(data_get($context->payload, 'id'))
                    ->whereNull('archived_at'),
            ],
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function messages(): array
    {
        return [
            'name.unique' => 'You already have a workspace with this name.',
        ];
    }
}
