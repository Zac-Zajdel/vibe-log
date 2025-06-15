<?php

declare(strict_types=1);

namespace App\Data\Transfer\WorkspaceUser;

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
        public readonly Optional|bool $is_active,
    ) {}
}
