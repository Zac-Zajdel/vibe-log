<?php

declare(strict_types=1);

namespace App\Data\Request\StandupGroup;

use App\Enums\StandupGroup\StandupGroupDay;
use App\Enums\StandupGroup\StandupGroupVisibility;
use App\Models\StandupGroup;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\Support\Validation\ValidationContext;

final class StandupGroupStoreData extends Data
{
    #[Exists(User::class, 'id')]
    public int $owner_id;

    #[Min(3), Max(255)]
    public string $name;

    #[Max(1000)]
    public Optional|string|null $description;

    public Optional|bool $is_active;

    public Optional|StandupGroupVisibility|null $visibility;

    /** @var StandupGroupDay[] */
    public Optional|array|null $days;

    /**
     * @return array<string, array<int, string|Unique>>
     */
    public static function rules(ValidationContext $context): array
    {
        /** @var User $user */
        $user = auth()->user();

        return [
            'name' => [
                'required',
                Rule::unique(StandupGroup::class, 'name')
                    ->where('workspace_id', $user->active_workspace_id),
            ],
        ];
    }
}
