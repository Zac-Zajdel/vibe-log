<?php

declare(strict_types=1);

namespace App\Data\Request\Workspace;

use App\Models\User;
use App\Models\Workspace;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\Support\Validation\ValidationContext;

final class WorkspaceStoreData extends Data
{
    #[Exists(User::class, 'id')]
    public int $owner_id;

    #[Min(3), Max(255)]
    public string $name;

    #[Max(1000)]
    public Optional|string|null $description;

    #[Max(255)]
    public Optional|string|null $logo;

    /**
     * @return array<string, array<int, string|Unique>>
     */
    public static function rules(ValidationContext $context): array
    {
        return [
            'name' => [
                'required',
                Rule::unique(Workspace::class, 'name')
                    ->where('owner_id', data_get($context->payload, 'owner_id'))
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
