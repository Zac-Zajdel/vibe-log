<?php

declare(strict_types=1);

namespace App\Data\Transfer\WorkspaceUser;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

final class WorkspaceUserData extends Data
{
    public function __construct(
        public readonly Optional|int $workspace_id,
        public readonly Optional|int $user_id,
        public readonly Optional|bool $is_active,
    ) {}
}
