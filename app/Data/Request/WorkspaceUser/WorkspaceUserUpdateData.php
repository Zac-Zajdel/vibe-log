<?php

declare(strict_types=1);

namespace App\Data\Request\WorkspaceUser;

use App\Models\Workspace;
use App\Models\WorkspaceUser;
use Spatie\LaravelData\Attributes\FromRouteParameterProperty;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;
use Spatie\TypeScriptTransformer\Attributes\Hidden;

final class WorkspaceUserUpdateData extends Data
{
    #[Hidden, Exists(Workspace::class, 'id'), FromRouteParameterProperty('workspace', 'id')]
    public int $workspace_id;

    #[Hidden, Exists(WorkspaceUser::class, 'user_id'), FromRouteParameterProperty('user', 'id')]
    public int $user_id;

    public Optional|bool $is_active;

    /**
     * @return array<string, string>
     */
    public static function messages(): array
    {
        return [
            'user_id.exists' => 'This user does not belong to this workspace.',
        ];
    }
}
