<?php

declare(strict_types=1);

namespace App\Data\Transfer\WorkspaceUser;

use App\Enums\Workspace\WorkspaceUserRole;
use App\Enums\Workspace\WorkspaceUserStatus;
use Carbon\Carbon;
use Spatie\LaravelData\Concerns\TransformableData;
use Spatie\LaravelData\Contracts\TransformableData as ContractsTransformableData;
use Spatie\LaravelData\Dto;
use Spatie\LaravelData\Optional;

final class WorkspaceUserData extends Dto implements ContractsTransformableData
{
    use TransformableData;

    public function __construct(
        public readonly Optional|int $workspace_id,
        public readonly Optional|int $user_id,
        public readonly Optional|string $username,
        public readonly Optional|string $avatar,
        public readonly Optional|WorkspaceUserRole $role,
        public readonly Optional|WorkspaceUserStatus $status,
        public readonly Optional|Carbon $joined_at,
    ) {}
}
