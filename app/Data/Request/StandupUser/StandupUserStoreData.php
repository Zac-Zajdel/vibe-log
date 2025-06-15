<?php

declare(strict_types=1);

namespace App\Data\Request\StandupUser;

use App\Models\StandupGroup;
use App\Models\StandupUser;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\Unique;
use Spatie\LaravelData\Attributes\FromRouteParameterProperty;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\Support\Validation\ValidationContext;
use Spatie\TypeScriptTransformer\Attributes\Hidden;

final class StandupUserStoreData extends Data
{
    #[Hidden, FromRouteParameterProperty('standup_group', 'id')]
    public int $standup_group_id;

    public int $user_id;

    public Optional|bool $is_active;

    /**
     * @return array<string, array<int, string|Unique|Exists>>
     */
    public static function rules(ValidationContext $context): array
    {
        /** @var User $user */
        $user = auth()->user();

        return [
            'standup_group_id' => [
                'required',
                Rule::exists(StandupGroup::class, 'id')
                    ->where('workspace_id', $user->active_workspace_id),
            ],
            'user_id' => [
                'required',
                // TODO - Verify user exists in the workspace.
                Rule::exists(User::class, 'id'),
                Rule::unique(StandupUser::class, 'user_id')
                    ->where('standup_group_id', $context->payload['standup_group_id']),
            ],
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function messages(): array
    {
        return [
            'user_id.unique' => 'This user already belongs to this standup group.',
        ];
    }
}
