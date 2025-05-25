<?php

declare(strict_types=1);

namespace App\Data\Request\Workspace;

use App\Models\User;
use App\Models\Workspace;
use Illuminate\Validation\Rule;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

final class WorkspaceStoreData extends Data
{
    #[Exists(User::class, 'id')]
    public int $user_id;

    #[Min(3), Max(255)]
    public string $name;

    #[Max(1000)]
    public ?string $description;

    #[Max(255)]
    public ?string $logo;

    /**
     * @return array<string, mixed>
     */
    public static function rules(ValidationContext $context): array
    {
        return [
            'name' => [
                Rule::unique(Workspace::class, 'name')
                    ->where('user_id', $context->payload['user_id'])
                    ->whereNull('archived_at'),
            ],
        ];
    }

    public static function messages(...$args): array
    {
        return [
            'name.unique' => 'You already have a workspace with this name.',
        ];
    }
}
