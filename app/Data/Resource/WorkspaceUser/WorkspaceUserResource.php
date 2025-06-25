<?php

declare(strict_types=1);

namespace App\Data\Resource\WorkspaceUser;

use App\Data\Resource\User\UserResource;
use App\Data\Resource\Workspace\WorkspaceResource;
use App\Models\WorkspaceUser;
use Carbon\CarbonImmutable;
use Spatie\LaravelData\Lazy;
use Spatie\LaravelData\Resource;

final class WorkspaceUserResource extends Resource
{
    public function __construct(
        public int $id,
        public int $workspace_id,
        public int $user_id,
        public bool $is_active,
        public ?CarbonImmutable $joined_at,
        public ?CarbonImmutable $created_at,
        public ?CarbonImmutable $updated_at,
        public Lazy|UserResource $user,
        public Lazy|WorkspaceResource $workspace,
    ) {}

    public static function fromModel(WorkspaceUser $workspaceUser): self
    {
        return new self(
            id: $workspaceUser->id,
            workspace_id: $workspaceUser->workspace_id,
            user_id: $workspaceUser->user_id,
            is_active: $workspaceUser->is_active,
            joined_at: $workspaceUser->joined_at,
            created_at: $workspaceUser->created_at,
            updated_at: $workspaceUser->updated_at,
            user: Lazy::whenLoaded(
                'user',
                $workspaceUser,
                fn (): UserResource => UserResource::fromModel($workspaceUser->user),
            ),
            workspace: Lazy::whenLoaded(
                'workspace',
                $workspaceUser,
                fn (): WorkspaceResource => WorkspaceResource::fromModel($workspaceUser->workspace),
            ),
        );
    }
}
