<?php

declare(strict_types=1);

namespace App\Data\Request\WorkspaceUser;

use App\Enums\Workspace\WorkspaceUserRole;
use App\Enums\Workspace\WorkspaceUserStatus;
use App\Models\WorkspaceUser;
use Illuminate\Validation\Rule;
use Spatie\LaravelData\Attributes\FromRouteParameterProperty;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\Support\Validation\ValidationContext;
use Spatie\TypeScriptTransformer\Attributes\Hidden;

final class WorkspaceUserUpdateData extends Data
{
    #[Hidden, FromRouteParameterProperty('workspaceUser', 'user_id')]
    public int $user_id;

    #[Min(2), Max(255)]
    public Optional|string $username;

    #[Max(255)]
    public Optional|string $avatar;

    public Optional|WorkspaceUserRole $role;

    public Optional|WorkspaceUserStatus $status;

    /**
     * @return array<string, list<\Illuminate\Validation\Rules\Enum|\Illuminate\Validation\Rules\Exists|string>>
     */
    public static function rules(ValidationContext $context): array
    {
        return [
            'user_id' => [
                'required',
                'int',
                Rule::exists(WorkspaceUser::class, 'user_id')
                    ->where('workspace_id', activeWorkspace()->id),
            ],
            'status' => [
                'nullable',
                Rule::enum(WorkspaceUserStatus::class)->only([
                    WorkspaceUserStatus::ACTIVE,
                    WorkspaceUserStatus::DISABLED,
                ]),
            ],
        ];
    }
}
