<?php

declare(strict_types=1);

namespace App\Data\Transfer\Workspace;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

final class WorkspaceData extends Data
{
    public function __construct(
        public readonly Optional|int $owner_id,
        public readonly Optional|string $name,
        public readonly Optional|string|null $description,
        public readonly Optional|string|null $logo,
        public readonly Optional|bool $is_default,
        public readonly Optional|string|null $archived_at,
    ) {}
}
